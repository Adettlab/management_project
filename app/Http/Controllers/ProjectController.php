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
        $this->middleware(function ($request, $next) {
            if ($this->isAuthorized()) {
                return $next($request);
            }

            return redirect()->route('projects.index');
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
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

        return view('project.index', [
            'title' => 'Projects',
            'active' => 'projects',
            'projects' => $projects,
            'directors' => $directors,
            'statuses' => ProjectStatus::all(),
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

    private function isAuthorized(): bool
    {
        $user = auth()->user();

        return $user->role === 'admin' ||
               ($user->employee && $user->employee->role->name === 'Project Director');
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
            // Rollback transaction if any operation fails
            DB::rollBack();

            // Optionally log the error for debugging
            logger()->error('Error creating project: '.$e->getMessage());

            // Return an error response
            return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::with(['level', 'status', 'employees.user'])->findOrFail($id);

        return view('project.show', [
            'title' => 'Project Details',
            'active' => 'projects',
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Project $project)
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');

    }
}
