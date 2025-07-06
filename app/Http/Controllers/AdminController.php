<?php
// File: app/Http/Controllers/AdminController.php (Complete & Fixed)

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\SiMenuWeb;
use App\Models\SisRolePartnerTypeMenuWeb;
use App\Models\SisRolePartnerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      if (!auth()->user()->employee) {
        return $next($request);
      }
      return redirect()->route('dashboard');
    });
  }

  public function index(Request $request)
  {
    $search = $request->input('search');
    $roleFilter = $request->input('role');

    $query = Employee::with(['user', 'role']);

    if (!empty($search)) {
      $query->whereHas('user', function ($q) use ($search) {
        $q->where('name', 'LIKE', '%' . $search . '%')
          ->orWhere('email', 'LIKE', '%' . $search . '%');
      });
    }

    if (!empty($roleFilter)) {
      $query->where('role_id', $roleFilter);
    }

    $employees = $query->paginate(10);
    $roles = Role::all();

    return view('admin.index', [
      "title" => "Admin",
      "active" => "admin",
      "roles" => $roles,
      "employees" => $employees,
      "search" => $search,
      "roleFilter" => $roleFilter,
    ]);
  }

  public function create()
  {
    $roles = Role::all();
    $menus = SiMenuWeb::all();

    // Exclude dashboard, activity, dan admin dari permission checkboxes
    $menusForPermissions = $menus->whereNotIn('teks', ['dashboard', 'activity', 'admin']);

    return view('admin.create', [
      "title" => "Create User",
      "active" => "admin",
      "roles" => $roles,
      "pages" => $menusForPermissions, // untuk backward compatibility dengan view
    ]);
  }

  public function store(Request $request)
  {
    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'work_email' => 'required|email|unique:employees,work_email',
        'password' => 'required|min:8|confirmed',
        'role_id' => 'required|exists:roles,id',
      ]);

      $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role_id'] == 2 ? 'admin' : 'user', // Project Director = admin role
      ]);

      $employee = Employee::create([
        'user_id' => $user->id,
        'role_id' => $validated['role_id'],
        'work_email' => $validated['work_email'],
      ]);

      // Create role partner type record - MINIMAL DATA
      SisRolePartnerType::create([
        'id_user' => $user->id,
        'id_role' => $validated['role_id'],
        'nama' => $validated['name'],
        // person_key dan pwd dibiarkan NULL
      ]);

      // Handle custom permissions - HANYA jika ada yang dicentang
      $permissions = $request->input('permissions', []);
      $hasCustomPermissions = false;

      if (!empty($permissions)) {
        foreach ($permissions as $menu_id => $permission_data) {
          // Check apakah ada permission yang di-set (hanya check field yang digunakan)
          $hasAnyPermission = isset($permission_data['allow_create']) ||
            isset($permission_data['allow_view']) ||
            isset($permission_data['allow_update']) ||
            isset($permission_data['allow_delete']);

          if ($hasAnyPermission) {
            SisRolePartnerTypeMenuWeb::create([
              'id_user' => $user->id,
              'menu_id' => $menu_id,
              'id_role' => $validated['role_id'],
              'allow_create' => isset($permission_data['allow_create']) ? true : false,
              'allow_view' => isset($permission_data['allow_view']) ? true : false,
              'allow_update' => isset($permission_data['allow_update']) ? true : false,
              'allow_delete' => isset($permission_data['allow_delete']) ? true : false,
              // Field yang tidak digunakan di-set false
              'allow_export' => false,
              'allow_import' => false,
              'allow_edit' => false,
              'is_visible' => true,
              // menu_id_ref dibiarkan NULL
            ]);
            $hasCustomPermissions = true;
          }
        }
      }

      // Pesan berdasarkan apakah ada custom permissions atau tidak
      $message = 'User created successfully!';
      if ($hasCustomPermissions) {
        $message .= ' Using custom permissions.';
      } else {
        $message .= ' Using default role-based permissions.';
      }

      return redirect()->route('admin.index')->with('success', $message);
    } catch (\Illuminate\Validation\ValidationException $e) {
      return redirect()->back()->withInput()->with('error', implode(' ', $e->validator->errors()->all()));
    } catch (\Exception $e) {
      return redirect()->back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
    }
  }

  public function edit($id)
  {
    $employee = Employee::with(['user.permissions.menu'])->findOrFail($id);
    $roles = Role::all();
    $statuses = ['Kontrak', 'Freelance', 'Tetap', 'Tenaga Ahli'];
    $menus = SiMenuWeb::whereNotIn('teks', ['dashboard', 'activity', 'admin'])->get();

    // Get existing permissions (hanya field yang digunakan)
    $userPermissions = [];
    foreach ($employee->user->permissions as $permission) {
      $userPermissions[$permission->menu_id] = [
        'allow_create' => $permission->allow_create,
        'allow_view' => $permission->allow_view,
        'allow_update' => $permission->allow_update,
        'allow_delete' => $permission->allow_delete,
        // Field yang tidak digunakan tidak perlu di-load
      ];
    }

    // Check if user has custom permissions
    $hasCustomPermissions = $employee->user->hasCustomPermissions();

    return view('admin.edit', [
      'title' => 'Edit Employee',
      'active' => 'admin',
      'employee' => $employee,
      'roles' => $roles,
      'statuses' => $statuses,
      'pages' => $menus, // untuk backward compatibility
      'userPermissions' => $userPermissions,
      'hasCustomPermissions' => $hasCustomPermissions,
    ]);
  }

  public function update(Request $request, $id)
  {
    $employee = Employee::findOrFail($id);

    $validated = $request->validate([
      'email' => 'required|email|unique:users,email,' . $employee->user_id,
      'work_email' => 'required|email|unique:employees,work_email,' . $employee->id,
      'photo' => 'nullable|image|max:2048',
      'nik' => 'nullable|string|max:255|unique:employees,nik,' . $employee->id,
      'status' => 'nullable|in:Kontrak,Freelance,Tetap,Tenaga Ahli',
      'birth_date' => 'nullable|date',
      'phone_number' => 'nullable|string|max:15',
      'telegram_link' => 'nullable|string|max:1000',
      'address' => 'nullable|string|max:255',
      'join_date' => 'nullable|date',
      'education' => 'nullable|string|max:255',
    ]);

    if ($request->hasFile('photo')) {
      if ($request->old_photo) {
        Storage::delete($request->old_photo);
      }
      $validated['photo'] = $request->file('photo')->store('users-image', 'public');
    }

    $employee->update($validated);

    // Update permissions - HANYA jika ada custom permissions yang dikirim
    $permissions = $request->input('permissions', []);

    // Delete existing custom permissions untuk menu yang bukan default
    $defaultMenus = SiMenuWeb::whereIn('teks', ['dashboard', 'activity'])->pluck('id');
    SisRolePartnerTypeMenuWeb::where('id_user', $employee->user_id)
      ->whereNotIn('menu_id', $defaultMenus)
      ->delete();

    // Add new permissions jika ada
    if (!empty($permissions)) {
      foreach ($permissions as $menu_id => $permission_data) {
        $hasAnyPermission = isset($permission_data['allow_create']) ||
          isset($permission_data['allow_view']) ||
          isset($permission_data['allow_update']) ||
          isset($permission_data['allow_delete']);

        if ($hasAnyPermission) {
          SisRolePartnerTypeMenuWeb::create([
            'id_user' => $employee->user_id,
            'menu_id' => $menu_id,
            'id_role' => $employee->role_id,
            'allow_create' => isset($permission_data['allow_create']) ? true : false,
            'allow_view' => isset($permission_data['allow_view']) ? true : false,
            'allow_update' => isset($permission_data['allow_update']) ? true : false,
            'allow_delete' => isset($permission_data['allow_delete']) ? true : false,
            // Field yang tidak digunakan di-set false
            'allow_export' => false,
            'allow_import' => false,
            'allow_edit' => false,
            'is_visible' => true,
            // menu_id_ref tetap NULL
          ]);
        }
      }
    }

    return redirect()->route('admin.index')->with('success', 'Employee updated successfully!');
  }

  public function destroy($id)
  {
    try {
      $employee = Employee::findOrFail($id);
      $user = $employee->user;

      // Delete related records
      SisRolePartnerTypeMenuWeb::where('id_user', $user->id)->delete();
      SisRolePartnerType::where('id_user', $user->id)->delete();

      $employee->delete();
      $user->delete();

      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
  }
}
