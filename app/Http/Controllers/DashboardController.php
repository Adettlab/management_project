<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
  private const PROJECT_STATUS_IN_PROGRESS = [2, 3]; // Status proyek yang sedang berjalan
  private const TASK_STATUS_COMPLETED = 4; // Status task yang sudah selesai
  private const TASK_STATUS_ACTIVE = [1, 2, 3, 4]; // Status task yang aktif atau selesai

  public function index(Request $request)
  {
    $status = $request->input('status', 'ready');
    $isCompleted = $status === 'Completed';
    if ($status == 'absent') {
      $employees = $this->getEmployeesAbsent();
    } else {
      $employees = $this->getEmployeesQuery($isCompleted, $status)->get();
    }

    // Get activity data for chart
    $activityData = $this->getActivityData($request);

    return view('dashboard', $this->buildViewData($status, $employees, $activityData));
  }

  // Method untuk mendapatkan query karyawan dengan filter yang diterapkan
  private function getEmployeesQuery(bool $isCompleted, string $status): Builder
  {
    return Employee::with([
      'user',
      'role',
      'projects' => fn($query) => $query->whereIn('project_status_id', self::PROJECT_STATUS_IN_PROGRESS),
      'projects.tasks' => fn($query) => $this->applyTaskStatusFilter($query, $isCompleted),
      'projects.tasks.assignedProjectEmployee',
      'projects.tasks.taskStatus',
      'projects.tasks.taskLevel',
    ])
      ->when(
        $isCompleted,
        fn($query) => $this->filterCompletedTasks($query),
        function ($query) use ($status) {
          if ($status === 'ready') {
            return $this->filterReadyEmployees($query, $status);
          }
          return $query->where('status_employee', $status);
        }
      );
  }

  private function applyTaskStatusFilter($query, bool $isCompleted)
  {
    return $query->when(
      $isCompleted,
      fn($q) => $q->where('task_status_id', self::TASK_STATUS_COMPLETED)->latest(),
      fn($q) => $q->whereIn('task_status_id', self::TASK_STATUS_ACTIVE)->latest()
    );
  }

  private function filterCompletedTasks(Builder $query): Builder
  {
    return $query->whereHas('projects.tasks', function ($query) {
      $query->where('task_status_id', self::TASK_STATUS_COMPLETED)
        ->whereHas('assignedProjectEmployee', function ($q) {
          $q->whereColumn('employees.id', 'project_employees.employee_id');
        });
    });
  }

  private function filterReadyEmployees(Builder $query, string $status): Builder
  {
    return $query
      ->where('status_employee', $status)
      ->whereHas('projects.tasks', function ($query) {
        $query->whereIn('task_status_id', self::TASK_STATUS_ACTIVE)
          ->whereHas('assignedProjectEmployee', function ($q) {
            $q->whereColumn('employees.id', 'project_employees.employee_id');
          });
      });
  }

  private function getEmployeesAbsent()
  {
    $today = now();

    $employees = Employee::whereHas('administration', function ($query) use ($today) {
      $query->whereDate('start_date', '<=', $today)
        ->whereDate('end_date', '>=', $today);
    })
      ->with('administration', 'administration.leavecategory', 'user')
      ->get();

    return $employees;
  }

  // New method untuk mendapatkan data activity
  private function getActivityData(Request $request)
  {
    $month = $request->input('month', now()->month);
    $year = $request->input('year', now()->year);

    // Get completed tasks for the selected month/year
    $completedTasks = Task::with(['assignedProjectEmployee.employee.user', 'project'])
      ->where('task_status_id', self::TASK_STATUS_COMPLETED)
      ->whereMonth('updated_at', $month)
      ->whereYear('updated_at', $year)
      ->orderBy('updated_at', 'desc')
      ->get();

    // Group by date and count completed tasks
    $dailyStats = $completedTasks->groupBy(function ($task) {
      return Carbon::parse($task->updated_at)->format('Y-m-d');
    })->map(function ($tasks) {
      return $tasks->count();
    });

    // Get top performers (employees with most completed tasks)
    $topPerformers = $completedTasks->groupBy(function ($task) {
      return $task->assignedProjectEmployee->employee_id ?? null;
    })->filter(function ($tasks, $employeeId) {
      return $employeeId !== null;
    })->map(function ($tasks, $employeeId) {
      $employee = $tasks->first()->assignedProjectEmployee->employee ?? null;
      return [
        'employee_id' => $employeeId,
        'employee_name' => $employee ? $employee->user->name : 'Unknown',
        'completed_count' => $tasks->count(),
        'latest_task' => $tasks->first()
      ];
    })->sortByDesc('completed_count')->take(5);

    return [
      'daily_stats' => $dailyStats,
      'top_performers' => $topPerformers,
      'recent_completions' => $completedTasks->take(10),
      'total_completed' => $completedTasks->count(),
      'current_month' => $month,
      'current_year' => $year,
      'month_name' => Carbon::create($year, $month)->format('F Y')
    ];
  }

  private function getTaskAndProject()
  {
    if (!auth()->user()->employee) {
      return [
        'projects' => [],
        'tasks' => []
      ];
    }

    $user = auth()->user()->employee->id;
    

    $projects = Project::whereHas('employees', function ($query) use ($user) {
      $query->where('project_employees.employee_id', $user);
    })
      ->with(['tasks' => function ($query) use ($user) {
        $query->whereIn('task_status_id', [1, 2,3])
          ->whereHas('assignedProjectEmployee', function ($subQuery) use ($user) {
            $subQuery->where('employee_id', $user);
          });
      }, 'status'])
      ->whereIn('project_status_id', [1, 2, 3])
      ->get();

    $tasks = collect();
    foreach ($projects as $project) {
      $tasks = $tasks->concat($project->tasks);
    }

    return [
      'projects' => $projects,
      'tasks' => $tasks
    ];
  }

  // Method untuk menyiapkan data yang akan ditampilkan pada view
  private function buildViewData(string $status, $employees, $activityData = []): array
  {
    return [
      'title' => 'Dashboard',
      'active' => 'dashboard',
      'filter' => $status, // Status yang dipilih untuk filter
      'employees' => $employees,
      'selectedStatus' => $status, // Status yang sedang aktif
      'activityData' => $activityData, // Data untuk activity chart
      'tasksnprojects' => $this->getTaskAndProject(),
    ];
  }
}
