<?php

namespace App\Http\Controllers;

use App\Jobs\BroadcastEmailJob;
use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectLevel;
use App\Models\ProjectStatus;
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
        // PERBAIKAN: Ganti dengan permission system yang baru
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
            ->whereHas('role', fn ($q) => $q->where('name', 'Project Director'))
            ->get();

        // PERBAIKAN: Tambah permission data untuk view
        $pagePermissions = $user->getPagePermissions('projects');

        return view('project.index', [
            'title' => 'Projects',
            'active' => 'projects',
            'projects' => $projects,
            'directors' => $directors,
            'statuses' => ProjectStatus::all(),
            'canCreate' => $pagePermissions['allow_create'],
            'canUpdate' => $pagePermissions['allow_update'],
            'canDelete' => $pagePermissions['allow_delete'],
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
            $query->whereHas('level', fn ($q) => $q->where('name', $level));
        }

        if ($director = $request->input('project_director')) {
            $query->whereHas('employees', function ($q) use ($director) {
                $q->where('employees.id', $director)
                  ->where('project_employees.isformeremployee', 0) // Only active directors
                  ->whereHas('role', fn ($q) => $q->where('name', 'Project Director'));
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

        $project->load(['employees' => function ($q) {
            $q->where('isformeremployee', false);
        }, 'level', 'status']);

        $employees = $project->employees;

        $roles = [
            'director' => 'Project Director',
            'analyst' => 'Analyst',
            'designer' => 'Designer',
            'engineerWeb' => 'Engineer Web',
            'engineerMobile' => 'Engineer Mobile',
            'engineerTester' => 'Engineer Tester',
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
            'director' => $employeeByRole['director'],
            'analyst' => $employeeByRole['analyst'],
            'designer' => $employeeByRole['designer'],
            'engineerWeb' => $employeeByRole['engineerWeb'],
            'engineerMobile' => $employeeByRole['engineerMobile'],
            'engineerTester' => $employeeByRole['engineerTester'],
        ], $this->getFormData());
    }

    public function show(string $id)
    {
        $project = Project::with(['level', 'status', 'employees.user'])->findOrFail($id);

        // PERBAIKAN: Cek akses individual project
        if (!$this->canUserAccessProject(auth()->user(), $project)) {
            abort(403, 'You do not have permission to view this project.');
        }

        $pagePermissions = auth()->user()->getPagePermissions('projects');

        return view('project.show', [
            'title' => 'Project Details',
            'active' => 'projects',
            'project' => $project,
            'canUpdate' => $pagePermissions['allow_update'],
            'canDelete' => $pagePermissions['allow_delete'],
        ]);
    }

    // PERBAIKAN: Helper method untuk cek akses project
    private function canUserAccessProject($user, $project)
    {
        if ($user->isAdmin()) return true;
        
        if ($user->hasCustomPermissions()) {
            $page = \App\Models\Page::where('name', 'projects')->first();
            if ($page) {
                $permission = $user->permissions()->where('page_id', $page->id)->first();
                if ($permission && $permission->allow_view) return true;
            }
        }
        
        if ($user->isProjectDirector()) return true;
        
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'project_level_id' => 'required|exists:project_levels,id',
            'project_status_id' => 'required|exists:project_statuses,id',
            'director_id' => 'nullable|exists:employees,id',
            'analyst_id' => 'nullable|exists:employees,id',
            'designer_id' => 'nullable|exists:employees,id',
            'engineer_web_id' => 'nullable|exists:employees,id',
            'engineer_mobile_id' => 'nullable|exists:employees,id',
            'engineer_tester_id' => 'nullable|exists:employees,id',
        ]);

        DB::beginTransaction();

        try {
            // Create the project
            $project = Project::create($validated);

            // Gather employee IDs
            $employeeIds = [];
            foreach (['director_id', 'analyst_id', 'designer_id', 'engineer_web_id', 'engineer_mobile_id', 'engineer_tester_id'] as $role) {
                if ($request->$role) {
                    $employeeIds[] = $request->$role;
                }
            }

            // Update status employee menjadi "Stand By"
            Employee::whereIn('id', $employeeIds)->update(['status_employee' => 'Stand By']);

            // Associate employees with the project
            $project->employees()->sync($employeeIds);

            // Send email notification to each assigned employee
            $employees = Employee::whereIn('id', $employeeIds)->get();
            $jobs = $employees->map(function ($employee) use ($project) {
                return new BroadcastEmailJob($project, $employee);
            });

            if (! empty($jobs)) {
                Bus::batch($jobs)
                    ->allowFailures()
                    ->onQueue('emails')
                    ->dispatch();
            }

            DB::commit();

            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            logger()->error('Error creating project: '.$e->getMessage());
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
                'director_id' => 'nullable|exists:employees,id',
                'analyst_id' => 'nullable|exists:employees,id',
                'designer_id' => 'nullable|exists:employees,id',
                'engineer_web_id' => 'nullable|exists:employees,id',
                'engineer_mobile_id' => 'nullable|exists:employees,id',
                'engineer_tester_id' => 'nullable|exists:employees,id',
            ]);

            DB::beginTransaction();
            $project->update($validated);

            $newEmployeeIds = collect([
                $request->director_id,
                $request->analyst_id,
                $request->designer_id,
                $request->engineer_web_id,
                $request->engineer_mobile_id,
                $request->engineer_tester_id,
            ])->filter()->all();

            $currentEmployeeIds = $project->employees()
                ->where('isformeremployee', 0)
                ->pluck('employee_id')
                ->toArray();

            $employeesToAdd = array_diff($newEmployeeIds, $currentEmployeeIds);
            $employeesToRemove = array_diff($currentEmployeeIds, $newEmployeeIds);

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

            foreach ($employeesToRemove as $employeeId) {
                $projectEmployee = DB::table('project_employees')
                    ->where('project_id', $project->id)
                    ->where('employee_id', $employeeId)
                    ->where('isformeremployee', 0)
                    ->first();

                if ($projectEmployee) {
                    DB::table('tasks')
                        ->where('assigned_project_employee_id', $projectEmployee->id)
                        ->where('task_status_id', 1)
                        ->delete();

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
}