<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Page;
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
        $pages = Page::all();

        // Exclude dashboard dan activity dari permission checkboxes
        $pagesForPermissions = $pages->whereNotIn('name', ['dashboard', 'activity','admin']);

        return view('admin.create', [
            "title" => "Create User",
            "active" => "admin",
            "roles" => $roles,
            "pages" => $pagesForPermissions,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
            ]);

            if ($validated['role_id'] == 2) {
                return redirect()->back()->withInput()->with('error', 'Tidak bisa membuat akun dengan role Project Director dari sini.');
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'user',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'role_id' => $validated['role_id'],
            ]);

            // Handle custom permissions HANYA jika ada yang dicentang
            $permissions = $request->input('permissions', []);
            $hasCustomPermissions = false;

            foreach ($permissions as $page_id => $permission_data) {
                // Check apakah ada permission yang di-set
                $hasAnyPermission = isset($permission_data['allow_create']) ||
                    isset($permission_data['allow_view']) ||
                    isset($permission_data['allow_update']) ||
                    isset($permission_data['allow_delete']);

                if ($hasAnyPermission) {
                    Permission::create([
                        'user_id' => $user->id,
                        'page_id' => $page_id,
                        'allow_create' => isset($permission_data['allow_create']) ? true : false,
                        'allow_view' => isset($permission_data['allow_view']) ? true : false,
                        'allow_update' => isset($permission_data['allow_update']) ? true : false,
                        'allow_delete' => isset($permission_data['allow_delete']) ? true : false,
                    ]);
                    $hasCustomPermissions = true;
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
        $employee = Employee::with(['user.permissions.page'])->findOrFail($id);
        $roles = Role::all();
        $statuses = ['Kontrak', 'Freelance', 'Tetap', 'Tenaga Ahli'];
        $pages = Page::whereNotIn('name', ['dashboard', 'activity', 'admin'])->get();

        // Get existing permissions
        $userPermissions = [];
        foreach ($employee->user->permissions as $permission) {
            $userPermissions[$permission->page_id] = [
                'allow_create' => $permission->allow_create,
                'allow_view' => $permission->allow_view,
                'allow_update' => $permission->allow_update,
                'allow_delete' => $permission->allow_delete,
            ];
        }

        // Check if user has custom permissions (exclude dashboard dan activity)
        $hasCustomPermissions = $employee->user->permissions()
            ->whereHas('page', function ($query) {
                $query->whereNotIn('name', ['dashboard', 'activity']);
            })
            ->exists();

        return view('admin.edit', [
            'title' => 'Edit Employee',
            'active' => 'admin',
            'employee' => $employee,
            'roles' => $roles,
            'statuses' => $statuses,
            'pages' => $pages,
            'userPermissions' => $userPermissions,
            'hasCustomPermissions' => $hasCustomPermissions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
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

        // Update permissions - SELALU jalankan bagian ini
        $permissions = $request->input('permissions', []);

        // Delete existing custom permissions (kecuali dashboard dan activity)
        $defaultPages = Page::whereIn('name', ['dashboard', 'activity'])->pluck('id');
        Permission::where('user_id', $employee->user_id)
            ->whereNotIn('page_id', $defaultPages)
            ->delete();

        // Add new permissions jika ada
        if (!empty($permissions)) {
            foreach ($permissions as $page_id => $permission_data) {
                $hasAnyPermission = isset($permission_data['allow_create']) ||
                    isset($permission_data['allow_view']) ||
                    isset($permission_data['allow_update']) ||
                    isset($permission_data['allow_delete']);

                if ($hasAnyPermission) {
                    Permission::create([
                        'user_id' => $employee->user_id,
                        'page_id' => $page_id,
                        'allow_create' => isset($permission_data['allow_create']) ? true : false,
                        'allow_view' => isset($permission_data['allow_view']) ? true : false,
                        'allow_update' => isset($permission_data['allow_update']) ? true : false,
                        'allow_delete' => isset($permission_data['allow_delete']) ? true : false,
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

            Permission::where('user_id', $user->id)->delete();
            $employee->delete();
            $user->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}