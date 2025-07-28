<?php

namespace App\Http\Controllers;

use App\Jobs\BroadcastEmailJob;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectLevel;
use App\Models\ProjectStatus;
use App\Models\SiMenuWeb; // Updated model
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
  private $commonData = null;

  public function __construct()
  {
    // PERBAIKAN: Menggunakan sistem permission yang baru
    $this->middleware(function ($request, $next) {
      $user = auth()->user();

      $action = 'view';
      if (in_array($request->route()->getActionMethod(), ['create', 'store'])) {
        $action = 'create';
      } elseif (in_array($request->route()->getActionMethod(), ['edit', 'update'])) {
        $action = 'update';
      } elseif ($request->route()->getActionMethod() === 'destroy') {
        $action = 'delete';
      }

      if ($user->hasPermission('projects', $action)) {
        return $next($request);
      }

      abort(403, 'You do not have permission to access this page.');
    });
  }

  public function index(Request $request)
  {
    $user = auth()->user();
    $query = Project::with([
      'employees.user',
      'employees.role',
      'status',
      'level'
    ]);

    $query = $this->applyFilters($query, $request, $user);
    $projects = $query->paginate(10);

    // Get directors for filter dropdown
    $directors = Employee::with('user')
      ->whereHas('role', fn($q) => $q->where('name', 'KEPALA PUSTIK'))
      ->get();

    // PERBAIKAN: Menggunakan method yang benar untuk get permissions
    $pagePermissions = $user->getMenuPermissions('projects');

    return view('project.index', [
      'title' => 'Projects',
      'active' => 'projects',
      'projects' => $projects,
      'directors' => $directors,
      'statuses' => ProjectStatus::all(),
      'canCreate' => $pagePermissions['allow_create'],
      'canUpdate' => $pagePermissions['allow_update'],
      'canDelete' => $pagePermissions['allow_delete'],
      // Field yang tidak digunakan dihapus
    ]);
  }

  private function applyFilters(Builder $query, Request $request, $user)
  {
    if ($user->employee) {
      $query->whereHas('employees', function ($q) use ($user) {
        $q->where('employees.id', $user->employee->id)
          ->where('project_employees.isformeremployee', 0);
      });
    }

    // Apply other filters
    if ($level = $request->input('project_level')) {
      $query->whereHas('level', fn($q) => $q->where('name', $level));
    }

    if ($director = $request->input('project_director')) {
      $query->whereHas('employees', function ($q) use ($director) {
        $q->where('employees.id', $director)
          ->where('project_employees.isformeremployee', 0) // Only active directors
          ->whereHas('role', fn($q) => $q->where('name', 'KEPALA PUSTIK'));
      });
    }

    if ($status = $request->input('project_status')) {
      $query->where('project_status_id', $status);
    }

    return $query;
  }

  public function create()
  {
    return view('project.create', array_merge([
      'title' => 'Create Project',
      'active' => 'projects',
    ], $this->getFormData()));
  }

  public function edit(Project $project)
  {
    // PERBAIKAN: Cek akses individual project
    if (!$this->canUserAccessProject(auth()->user(), $project)) {
      abort(403, 'You do not have permission to edit this project.');
    }

    $project->load([
      'employees' => function ($q) {
        $q->where('isformeremployee', false);
      },
      'level',
      'status'
    ]);

    $employees = $project->employees;

    $roles = [
      'kepala' => 'KEPALA PUSTIK',
      'PelaporanPDDIKTI' => 'Pelaporan PDDIKTI',
      'Teknisi' => 'TEKNISI',
      'asistenDosen' => 'Asisten DOSEN',
      'jaringanInstalasi' => 'Jaringan Dan Instalasi',
      'PengelolaSosmed' => 'Pengelola Sosial Media',
    ];

    $employeeByRole = [];
    foreach ($roles as $key => $roleName) {
      $employeeByRole[$key] = $employees->firstWhere('role.name', $roleName);
    }

    return view('project.edit', [
      'title' => 'Edit Project',
      'active' => 'projects',
      'project' => $project,
      'employeeIds' => $employees->pluck('id')->toArray(),
      'kepala' => $employeeByRole['kepala'],
      'PelaporanPDDIKTI' => $employeeByRole['PelaporanPDDIKTI'],
      'Teknisi' => $employeeByRole['Teknisi'],
      'asistenDosen' => $employeeByRole['asistenDosen'],
      'jaringanInstalasi' => $employeeByRole['jaringanInstalasi'],
      'PengelolaSosmed' => $employeeByRole['PengelolaSosmed'],
    ], $this->getFormData());
  }

  public function show(string $id)
  {
    $project = Project::with(['level', 'status', 'employees.user'])->findOrFail($id);

    // PERBAIKAN: Cek akses individual project
    if (!$this->canUserAccessProject(auth()->user(), $project)) {
      abort(403, 'You do not have permission to view this project.');
    }

    $pagePermissions = auth()->user()->getMenuPermissions('projects');

    return view('project.show', [
      'title' => 'Project Details',
      'active' => 'projects',
      'project' => $project,
      'canUpdate' => $pagePermissions['allow_update'],
      'canDelete' => $pagePermissions['allow_delete'],
      // Field yang tidak digunakan dihapus
    ]);
  }

  // PERBAIKAN: Helper method untuk cek akses project dengan sistem baru
  private function canUserAccessProject($user, $project)
  {
    // Admin selalu bisa akses
    if ($user->isAdmin())
      return true;

    // KEPALA PUSTIK selalu bisa akses
    if ($user->isProjectDirector())
      return true;

    // Cek custom permission jika ada
    if ($user->hasCustomPermissions()) {
      $menu = SiMenuWeb::where('teks', 'projects')->first();
      if ($menu) {
        $permission = $user->permissions()->where('menu_id', $menu->id)->first();
        if ($permission && $permission->allow_view) {
          // Jika punya custom permission view, bisa akses project yang dia terlibat
          if ($user->employee) {
            return $project->employees()
              ->where('employees.id', $user->employee->id)
              ->where('project_employees.isformeremployee', 0)
              ->exists();
          }
        }
      }
    }

    // Default: cek apakah user terlibat dalam project
    if ($user->employee) {
      return $project->employees()
        ->where('employees.id', $user->employee->id)
        ->where('project_employees.isformeremployee', 0)
        ->exists();
    }

    return false;
  }

  private function getFormData(): array
  {
    if ($this->commonData !== null) {
      return $this->commonData;
    }

    $this->commonData = [
      'levels' => ProjectLevel::all(),
      'statuses' => ProjectStatus::all(),
      'employees' => Employee::with(['user', 'role'])->get(),
    ];

    return $this->commonData;
  }

  // public function store(Request $request)
  // {
  //   $validated = $request->validate([
  //     'name' => 'required|string|max:255',
  //     'description' => 'nullable',
  //     'start_date' => 'required|date',
  //     'end_date' => 'required|date|after_or_equal:start_date',
  //     'project_level_id' => 'required|exists:project_levels,id',
  //     'project_status_id' => 'required|exists:project_statuses,id',
  //     'kepala_id' => 'nullable|exists:employees,id',
  //     'sdm_ids' => 'nullable|array',
  //     'sdm_ids.*' => 'exists:employees,id',
  //   ]);

  //   DB::beginTransaction();

  //   try {
  //     // Create the project
  //     $project = Project::create($validated);

  //     // Ambil semua SDM (tambahkan juga kepala jika mau)
  //     $employeeIds = $validated['sdm_ids'] ?? [];

  //     if (!empty($validated['kepala_id'])) {
  //       $employeeIds[] = $validated['kepala_id'];
  //     }

  //     $employeeIds = array_unique($employeeIds);

  //     Employee::whereIn('id', $employeeIds)->update(['status_employee' => 'Stand By']);


  //     // Remove duplicates
  //     $employeeIds = array_unique($employeeIds);

  //     // Update status employee menjadi "Stand By"
  //     Employee::whereIn('id', $employeeIds)->update(['status_employee' => 'Stand By']);

  //     // Associate employees with the project
  //     $project->employees()->sync($employeeIds);

  //     // Send email notification to each assigned employee
  //     if (!empty($employeeIds)) {
  //       $employees = Employee::whereIn('id', $employeeIds)->get();
  //       $jobs = $employees->map(function ($employee) use ($project) {
  //         return new BroadcastEmailJob($project, $employee);
  //       });

  //       Bus::batch($jobs)
  //         ->allowFailures()
  //         ->onQueue('emails')
  //         ->dispatch();
  //     }

  //     DB::commit();

  //     return redirect()->route('projects.index')->with('success', 'Project created successfully.');
  //   } catch (\Exception $e) {
  //     DB::rollBack();
  //     Log::error('Error creating project: ' . $e->getMessage());
  //     return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
  //   }
  // }


  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable',
      'start_date' => 'required|date',
      'end_date' => 'required|date|after_or_equal:start_date',
      'project_level_id' => 'required|exists:project_levels,id',
      'project_status_id' => 'required|exists:project_statuses,id',
      'kepala_id' => 'nullable|exists:employees,id',
      'pelaporan_pddikti_id' => 'nullable|exists:employees,id',
      'asisten_id' => 'nullable|exists:employees,id',
      'jaringan_instalasi_id' => 'nullable|exists:employees,id',
      'teknisi_id' => 'nullable|exists:employees,id',
      'pengelola_sosmed_id' => 'nullable|exists:employees,id',
      // Add validation for new SDM system
      'sdm_ids' => 'nullable|array',
      'sdm_ids.*' => 'exists:employees,id',
    ]);

    DB::beginTransaction();

    try {
      // Create the project
      $project = Project::create($validated);

      // Gather employee IDs from individual role fields (original system)
      $employeeIds = [];
      foreach (['kepala_id', 'pelaporan_pddikti_id', 'asisten_id', 'jaringan_instalasi_id', 'teknisi_id', 'pengelola_sosmed_id'] as $role) {
        if ($request->$role) {
          $employeeIds[] = $request->$role;
        }
      }

      // Add SDM IDs from new autocomplete system
      if ($request->has('sdm_ids') && is_array($request->sdm_ids)) {
        $employeeIds = array_merge($employeeIds, $request->sdm_ids);
      }

      // Remove duplicates and filter out empty values
      $employeeIds = array_filter(array_unique($employeeIds));

      if (!empty($employeeIds)) {
        // Update status employee menjadi "Stand By"
        Employee::whereIn('id', $employeeIds)->update(['status_employee' => 'Stand By']);

        // Associate employees with the project
        $project->employees()->sync($employeeIds);

        // Send email notification to each assigned employee
        $employees = Employee::whereIn('id', $employeeIds)->get();
        $jobs = $employees->map(function ($employee) use ($project) {
          return new BroadcastEmailJob($project, $employee);
        });

        Bus::batch($jobs)
          ->allowFailures()
          ->onQueue('emails')
          ->dispatch();
      }

      DB::commit();

      return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error creating project: ' . $e->getMessage());
      return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
    }
  }

  public function update(Request $request, Project $project)
  {
    // PERBAIKAN: Cek akses individual project
    if (!$this->canUserAccessProject(auth()->user(), $project)) {
      abort(403, 'You do not have permission to update this project.');
    }

    try {
      $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'project_level_id' => 'required|exists:project_levels,id',
        'project_status_id' => 'required|exists:project_statuses,id',
        'kepala_id' => 'nullable|exists:employees,id',
        'pelaporan_pddikti_id' => 'nullable|exists:employees,id',
        'asisten_id' => 'nullable|exists:employees,id',
        'jaringan_instalasi_id' => 'nullable|exists:employees,id',
        'teknisi_id' => 'nullable|exists:employees,id',
        'pengelola_sosmed_id' => 'nullable|exists:employees,id',
      ]);

      DB::beginTransaction();
      $project->update($validated);

      $newEmployeeIds = collect([
        $request->kepala_id,
        $request->pelaporan_pddikti_id,
        $request->asisten_id,
        $request->jaringan_instalasi_id,
        $request->teknisi_id,
        $request->pengelola_sosmed_id,
      ])->filter()->unique()->all();

      $currentEmployeeIds = $project->employees()
        ->where('isformeremployee', 0)
        ->pluck('employee_id')
        ->toArray();

      $employeesToAdd = array_diff($newEmployeeIds, $currentEmployeeIds);
      $employeesToRemove = array_diff($currentEmployeeIds, $newEmployeeIds);

      // Add new employees
      foreach ($employeesToAdd as $employeeId) {
        $existingRecord = DB::table('project_employees')
          ->where('project_id', $project->id)
          ->where('employee_id', $employeeId)
          ->first();

        if ($existingRecord) {
          DB::table('project_employees')
            ->where('id', $existingRecord->id)
            ->update(['isformeremployee' => 0]);
        } else {
          $project->employees()->attach($employeeId);
        }
      }

      // Remove employees
      foreach ($employeesToRemove as $employeeId) {
        $projectEmployee = DB::table('project_employees')
          ->where('project_id', $project->id)
          ->where('employee_id', $employeeId)
          ->where('isformeremployee', 0)
          ->first();

        if ($projectEmployee) {
          // Delete unfinished tasks
          DB::table('tasks')
            ->where('assigned_project_employee_id', $projectEmployee->id)
            ->where('task_status_id', 1)
            ->delete();

          // Mark as former employee
          DB::table('project_employees')
            ->where('id', $projectEmployee->id)
            ->update(['isformeremployee' => 1]);
        }
      }

      $message = 'Project updated successfully.';
      if (!empty($employeesToAdd) || !empty($employeesToRemove)) {
        $message .= ' Employee assignments updated.';
      }

      DB::commit();

      return redirect()
        ->route('projects.index')
        ->with('success', $message);
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('Error updating project: ' . $e->getMessage());
      return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
    }
  }

  public function destroy(Project $project)
  {
    // PERBAIKAN: Cek akses individual project
    if (!$this->canUserAccessProject(auth()->user(), $project)) {
      return response()->json([
        'success' => false,
        'message' => 'You do not have permission to delete this project.'
      ], 403);
    }

    try {
      $project->delete();
      return response()->json([
        'success' => true,
        'message' => 'Project deleted successfully.'
      ]);
    } catch (\Exception $e) {
      Log::error('Error deleting project: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Something went wrong. Please try again or contact support.'
      ], 500);
    }
  }

  public function searchSDM(Request $request)
  {
    $query = $request->get('query', '');

    if (strlen($query) < 1) {
      return response()->json([]);
    }

    // Search employees excluding those with role "KEPALA PUSTIK"
    $employees = Employee::with(['user', 'role'])
      ->whereHas('user', function ($q) use ($query) {
        $q->where('name', 'LIKE', '%' . $query . '%');
      })
      ->whereHas('role', function ($q) {
        $q->where('name', '!=', 'KEPALA PUSTIK');
      })
      ->limit(10)
      ->get()
      ->map(function ($employee) {
        return [
          'id' => $employee->id,
          'name' => $employee->user->name,
          'email' => $employee->user->email,
          'role' => $employee->role->name ?? 'No Role'
        ];
      });

    return response()->json($employees);
  }
}
