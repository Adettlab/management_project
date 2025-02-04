<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private const PROJECT_STATUS_IN_PROGRESS = [2, 3]; // Status proyek yang sedang berjalan
    private const TASK_STATUS_COMPLETED = 4; // Status task yang sudah selesai
    private const TASK_STATUS_ACTIVE = [3, 4]; // Status task yang aktif atau selesai

    public function index(Request $request)
    {
        $status = $request->input('status', 'ready');
        $isCompleted = $status === 'Completed';
        if ($status == 'absent'){
            $employees = $this->getEmployeesAbsent();
        } else{
            $employees = $this->getEmployeesQuery($isCompleted, $status)->get();
        }

        return view('dashboard', $this->buildViewData($status, $employees));
    }

    // Method untuk mendapatkan query karyawan dengan filter yang diterapkan
    private function getEmployeesQuery(bool $isCompleted, string $status): Builder
    {
        return Employee::with([
            'user',
            'role',
            'projects' => fn ($query) => $query->whereIn('project_status_id', self::PROJECT_STATUS_IN_PROGRESS),
            'projects.tasks' => fn ($query) => $this->applyTaskStatusFilter($query, $isCompleted),
            'projects.tasks.assignedProjectEmployee',
            'projects.tasks.taskStatus',
            'projects.tasks.taskLevel',
        ])
            ->when(
                $isCompleted,
                fn ($query) => $this->filterCompletedTasks($query),
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
            fn ($q) => $q->where('task_status_id', self::TASK_STATUS_COMPLETED)->latest(),
            fn ($q) => $q->whereIn('task_status_id', self::TASK_STATUS_ACTIVE)->latest()
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

        $employees = Employee::whereHas('administration', function($query) use ($today) {
            $query->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today);
        })
            ->with('administration', 'administration.leavecategory', 'user')
            ->get();

        return $employees;
    }

    // Method untuk menyiapkan data yang akan ditampilkan pada view
    private function buildViewData(string $status, $employees): array
    {
        return [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'filter' => $status, // Status yang dipilih untuk filter
            'employees' => $employees,
            'selectedStatus' => $status, // Status yang sedang aktif
        ];
    }
}
