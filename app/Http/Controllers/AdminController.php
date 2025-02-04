<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

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
        // // Periksa apakah pengguna adalah admin
        // $user = auth()->user(); // Mendapatkan pengguna yang sedang login
        // if ($user->role !== 'admin') {
        //   abort(403, 'Anda tidak memiliki akses ke halaman ini.'); // Forbidden
        // }

        // Ambil query untuk search dan filter
        $search = $request->input('search');
        $roleFilter = $request->input('role');

        // Query employees melalui relasi
        $query = Employee::with(['user', 'role']);

        // Filter berdasarkan search
        if (!empty($search)) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%') // Filter nama user
                  ->orWhere('email', 'LIKE', '%' . $search . '%'); // Filter email user
            });
        }

        // Filter berdasarkan role (opsional)
        if (!empty($roleFilter)) {
            $query->where('role_id', $roleFilter);
        }

        // Paginate hasil query
        $employees = $query->paginate(10);

        // Ambil semua role
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
        // // Periksa apakah pengguna adalah admin
        // $user = auth()->user(); // Mendapatkan pengguna yang sedang login
        // if ($user->role !== 'admin') {
        //   abort(403, 'Anda tidak memiliki akses ke halaman ini.'); // Forbidden
        // }

        $roles = Role::all();
        return view('admin.create', [
          "title" => "Create User",
          "active" => "admin",
          "roles" => $roles,
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

            $user = User::create([
              'name' => $validated['name'],
              'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $validated['role_id'] == 2 ? 'admin' : 'user',
            ]);

            Employee::create([
              'user_id' => $user->id,
              'role_id' => $validated['role_id'],
            ]);

            return redirect()->route('admin.index')->with('success', 'User created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', implode(' ', $e->errors()));
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create user: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $roles = Role::all();
        $statuses = Employee::getStatuses();

        return view('admin.edit', [
          'title' => 'Edit Employee',
          'active' => 'admin',
          'employee' => $employee,
          'roles' => $roles,
          'statuses' => $statuses,
        ]);
    }

    public function update(Request $request, $id)
    {

        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
          'work_email' => 'required|email|unique:employees,work_email,' . $employee->id,
          'photo' => 'nullable|image|max:2048', // Maksimum ukuran 2MB
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
        // Update data employee
        $employee->update($validated);

        return redirect()->route('admin.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $user = $employee->user;

            $employee->delete();
            $user->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
