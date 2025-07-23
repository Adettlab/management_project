<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Project;
use App\Models\ProjectEmployee;
use App\Models\SiMenuWeb;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $user = auth()->user();

      // Cek apakah user punya employee
      if (!$user->employee) {
        return redirect()->route('dashboard');
      }

      // HANYA untuk custom permission, cek permission tasks
      // User dengan role default (admin, user biasa) tetap bisa akses
      if ($user->hasCustomPermissions()) {
        $action = 'view';
        if (in_array($request->route()->getActionMethod(), ['store'])) {
          $action = 'create';
        } elseif (in_array($request->route()->getActionMethod(), ['update', 'updateStatus'])) {
          $action = 'update';
        } elseif ($request->route()->getActionMethod() === 'destroy') {
          $action = 'delete';
        }

        if (!$user->hasPermission('tasks', $action)) {
          abort(403, 'You do not have permission to access this page.');
        }
      }

      return $next($request);
    });
  }

  public function index()
  {
    $user = auth()->user();
    $projects = Project::with([
      'employees' => function ($query) {
        $query->where('isformeremployee', false);
      },
      'employees.user'
    ])
      ->whereHas('employees', function ($query) use ($user) {
        $query->where('employee_id', $user->employee->id)
          ->where('isformeremployee', false);
      })
      ->whereIn('project_status_id', [2, 3])
      ->get();

    // Default permissions untuk user biasa
    $pagePermissions = [
      'allow_create' => true,
      'allow_update' => true,
      'allow_delete' => true,
    ];

    // HANYA override jika user punya custom permissions
    if ($user->hasCustomPermissions()) {
      $pagePermissions = $user->getMenuPermissions('tasks');
    }

    // Logic khusus untuk All Task dan Transfer Task (hanya KEPALA PUSTIK dan Admin)
    $isProjectDirector = $user->employee && $user->employee->role->name === 'KEPALA PUSTIK';
    $isAdmin = $user->role === 'admin';

    return view('task.index', [
      'title' => 'Tasks',
      'active' => 'tasks',
      'projects' => $projects,
      'canCreate' => $pagePermissions['allow_create'],
      'canUpdate' => $pagePermissions['allow_update'],
      'canDelete' => $pagePermissions['allow_delete'],
      'canTransfer' => $isAdmin || $isProjectDirector, // Khusus untuk transfer task
      'canSeeAllTask' => $isAdmin || $isProjectDirector, // Khusus untuk see all task
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
    $user = auth()->user();
    $date = $request->query('date', now()->toDateString());
    $isAdmin = $user->employee && $user->employee->role->name === 'KEPALA PUSTIK';
    $isToday = trim($date) === now()->toDateString();

    $query = Project::query();

    $tasksQuery = function ($query) use ($date, $user, $isAdmin, $isToday) {
      $query->where(function ($q) use ($date, $isToday) {
        $q->whereDate('created_at', $date);

        if ($isToday) {
          $q->orWhere('task_status_id', 1);
        }
      });

      if (!$isAdmin) {
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
      if (!$isAdmin) {
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

  public function store(Request $request)
  {
    // HANYA cek permission jika user punya custom permission
    $user = auth()->user();
    if ($user->hasCustomPermissions() && !$user->hasPermission('tasks', 'create')) {
      abort(403, 'You do not have permission to create tasks.');
    }

    try {
      $validated = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'name' => 'required|string|max:255',
        'task_status_id' => 'required|exists:task_statuses,id',
        'task_level_id' => 'required|exists:task_levels,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
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

  public function allTask(Request $request)
  {
    $user = auth()->user();

    // Hanya Admin atau KEPALA PUSTIK yang bisa akses (tidak terpengaruh custom permission)
    $isProjectDirector = $user->employee && $user->employee->role->name === 'KEPALA PUSTIK';
    $isAdmin = $user->role === 'admin';

    if (!$isAdmin && !$isProjectDirector) {
      abort(403, 'You do not have permission to view all tasks.');
    }

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

    $tasks = $tasksQuery->paginate(10);

    return view('task.all_task', [
      'title' => 'Task',
      'active' => 'tasks',
      'tasks' => $tasks,
    ]);
  }

  public function update(Request $request, task $task)
  {
    // Cek permission untuk update
    $user = auth()->user();
    if ($user->hasCustomPermissions() && !$user->hasPermission('tasks', 'update')) {
      abort(403, 'You do not have permission to update tasks.');
    }

    // Cek apakah user bisa akses task ini
    if (!$this->canUserAccessTask($user, $task)) {
      abort(403, 'You do not have permission to update this task.');
    }

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
    // Cek permission untuk update
    $user = auth()->user();
    if ($user->hasCustomPermissions() && !$user->hasPermission('tasks', 'update')) {
      return response()->json([
        'success' => false,
        'message' => 'You do not have permission to update task status.'
      ], 403);
    }

    $task = Task::findOrFail($id);

    // Cek apakah user bisa akses task ini
    if (!$this->canUserAccessTask($user, $task)) {
      return response()->json([
        'success' => false,
        'message' => 'You do not have permission to update this task.'
      ], 403);
    }

    // Validasi hanya task_status_id untuk pembaruan status
    $validated = $request->validate([
      'task_status_id' => 'required|exists:task_statuses,id',
    ]);

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

  public function destroy(Task $task)
  {
    // Cek permission untuk delete
    $user = auth()->user();
    if ($user->hasCustomPermissions() && !$user->hasPermission('tasks', 'delete')) {
      return response()->json([
        'success' => false,
        'message' => 'You do not have permission to delete tasks.'
      ], 403);
    }

    // Cek apakah user bisa akses task ini
    if (!$this->canUserAccessTask($user, $task)) {
      return response()->json([
        'success' => false,
        'message' => 'You do not have permission to delete this task.'
      ], 403);
    }

    try {
      $task->delete();
      return response()->json([
        'success' => true,
        'message' => 'Task deleted successfully.'
      ]);
    } catch (\Exception $e) {
      Log::error('Error deleting task: ' . $e->getMessage());
      return response()->json([
        'success' => false,
        'message' => 'Something went wrong. Please try again or contact support.'
      ], 500);
    }
  }

  // Helper method untuk cek akses task
  private function canUserAccessTask($user, $task)
  {
    // Admin selalu bisa akses
    if ($user->role === 'admin')
      return true;

    // KEPALA PUSTIK selalu bisa akses
    if ($user->employee && $user->employee->role->name === 'KEPALA PUSTIK')
      return true;

    // Cek custom permission jika ada
    if ($user->hasCustomPermissions()) {
      $menu = SiMenuWeb::where('teks', 'tasks')->first();
      if ($menu) {
        $permission = $user->permissions()->where('menu_id', $menu->id)->first();
        if ($permission && ($permission->allow_view || $permission->allow_update || $permission->allow_delete)) {
          // Jika punya custom permission, cek apakah task assigned ke user tersebut
          if ($user->employee) {
            return $task->assignedProjectEmployee &&
              $task->assignedProjectEmployee->employee_id === $user->employee->id;
          }
        }
      }
    }

    // Default: cek apakah task assigned ke user
    if ($user->employee) {
      return $task->assignedProjectEmployee &&
        $task->assignedProjectEmployee->employee_id === $user->employee->id;
    }

    return false;
  }
}
