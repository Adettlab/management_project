<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\TryCatch;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            if (!$user->employee) {
                return redirect()->route('dashboard');
            }

            return $next($request);
        });
    }

    public function index()
    {
        $user = auth()->user();
        $projects = Project::with(['employees' => function ($query) {
            $query->where('isformeremployee', false);
        }, 'employees.user'])
            ->whereHas('employees', function ($query) use ($user) {
                $query->where('employee_id', $user->employee->id)
                      ->where('isformeremployee', false);
            })
            ->whereIn('project_status_id', [2, 3])
            ->get();

        return view('task.index', [
            'title' => 'Tasks',
            'active' => 'tasks',
            'projects' => $projects,
        ]);
    }

    public function getEmployees(Request $request)
    {
        $project_id = $request->id;
        if ($request->query('type') == 'team') {
            $projectEmployees = ProjectEmployee::with('employee', 'employee.user')->where('project_id', $project_id)->where('isformeremployee', 0)->get();
        } else {
            $projectEmployees = ProjectEmployee::where('employee_id', auth()->user()->employee->id)->where('project_id', $project_id)->get();
        }

        return response()->json($projectEmployees);
    }

    public function getTasks(Request $request)
    {
        /*
          1. ambil semua project termasuk relasi tasks dan employees dll yang dibutuhkan
          2. jika user adalah admin, maka ambil semua project
          3. jika user bukan admin, maka ambil project yang memiliki employee_id yang sama dengan employee_id user
          4. jika request memiliki query date, maka return semua data yang sudah difilter berdasarkan admin dan created_at berdasarkan query date
          5. jika request tidak memiliki query date maka filter project dimana created_at = variable date dan task_status_id = 1
        */

        $user = auth()->user();
        $date = $request->query('date', now()->toDateString());
        $isAdmin = $user->employee && $user->employee->role->name === 'Project Director';
        $isToday = trim($date) === now()->toDateString();

        $query = Project::query();

        $tasksQuery = function ($query) use ($date, $user, $isAdmin, $isToday) {
            $query->where(function ($q) use ($date, $isToday) {
                $q->whereDate('created_at', $date);

                if ($isToday) {
                    $q->orWhere('task_status_id', 1);
                }
            });

            if (! $isAdmin) {
                $query->whereHas('assignedProjectEmployee', function ($q) use ($user) {
                    $q->where('employee_id', $user->employee->id);
                });
            } else {
                $query->whereHas('project.employees', function ($q) use ($user) {
                    $q->where('employee_id', $user->employee->id);
                });
            }
        };

        $employeesQuery = function ($query) use ($user, $isAdmin) {
            if (! $isAdmin) {
                $query->where('employee_id', $user->employee->id);
            }
        };

        $query->with([
            'employees' => $employeesQuery,
            'employees.user',
            'employees.role',
            'tasks' => $tasksQuery,
            'tasks.taskStatus',
            'tasks.taskLevel',
            'tasks.assignedProjectEmployee',
            'tasks.timeLog',
        ]);

        $query->whereHas('tasks', $tasksQuery);

        $projects = $query->get();

        return response()->json($projects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'name' => 'required|string|max:255',
                'task_status_id' => 'required|exists:task_statuses,id',
                'task_level_id' => 'required|exists:task_levels,id',
                'assigned_project_employee_id' => 'required|exists:project_employees,id',
            ]);
            Task::create($validated);
            // Ambil employee_id dari project_employees
            $projectEmployee = ProjectEmployee::findOrFail($validated['assigned_project_employee_id']);

            // Update status SDM menjadi "Ready"
            Employee::where('id', $projectEmployee->employee_id)->update(['status_employee' => 'Ready']);

            return redirect()->route('tasks.index')
                ->with('success', 'Task created successfully.');
        } catch (\Throwable $th) {
            Log::error('error creating task ' . $th);
            return back()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
        }
    }

    // show all task
    public function allTask(Request $request)
    {
        $user = auth()->user();

        // Base query
        $tasksQuery = Task::with(['project', 'taskStatus', 'taskLevel', 'assignedProjectEmployee']);

        // Filter task level
        if ($request->has('task_level') && $request->task_level) {
            $tasksQuery->whereHas('taskLevel', function ($query) use ($request) {
                $query->where('name', $request->task_level);
            });
        }

        // Filter task status
        if ($request->has('task_status') && $request->task_status) {
            $tasksQuery->whereHas('taskStatus', function ($query) use ($request) {
                $query->where('name', $request->task_status);
            });
        }

        // // Urutkan berdasarkan tanggal
        // $tasksQuery->orderBy('created_at', 'asc');
        $tasks = $tasksQuery->paginate(10);

        return view('task.all_task', [
            'title' => 'Task',
            'active' => 'tasks',
            'tasks' => $tasks,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, task $task)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'task_level_id' => 'required|exists:task_levels,id',
            ]);

            $task->update($validated);

            return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Error updating task ' . $th);
            return back()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        // Validasi hanya task_status_id untuk pembaruan status
        $validated = $request->validate([
            'task_status_id' => 'required|exists:task_statuses,id',
        ]);
        // Temukan task berdasarkan id yang diberikan
        $task = Task::findOrFail($id);

        // Update task_status_id
        $task->task_status_id = $validated['task_status_id'];
        $task->save();

        $task->load('timeLog', 'taskStatus');

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully',
            'task' => $task,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
