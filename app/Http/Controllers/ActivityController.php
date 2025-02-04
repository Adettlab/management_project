<?php

namespace App\Http\Controllers;

use App\Models\Administration;
use App\Models\Employee;
use App\Models\ProjectEmployee;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $monthInput = $request->input('month');
        if (! $monthInput) {
            $date = now();
        } else {
            $date = Carbon::createFromFormat('Y-m', $monthInput);
        }

        $employeesQuery = Employee::with('user', 'role');
        $employees = $employeesQuery->paginate(6);
        foreach ($employees as $employee) {
            // Calculate total projects
            $employee->sumProjects = ProjectEmployee::where('employee_id', $employee->id)
                ->distinct('project_id')
                ->count();

            [$totalTask, $totalWorkDuration] = $this->getTotalTaskAndWorkDuration($employee, $date);

            $employee->totalWorkDuration = $totalWorkDuration;
            $employee->sumTasks = $totalTask;
            $employee->totalDayOff = $this->getDayOff($employee);
        }

        return view('activity.index', [
            'title' => 'Activity',
            'active' => 'activity',
            'employees' => $employees,
        ]);
    }

    private function getTotalTaskAndWorkDuration($employee, $date){
        $tasks = Task::with(['taskLevel', 'timeLog'])
            ->where('task_status_id', 4)
            ->whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->whereHas('assignedProjectEmployee', function ($query) use ($employee) {
                $query->where('employee_id', $employee->id);
            })
            ->get();

        $totalWorkDuration = 0;

        foreach ($tasks as $task) {
            $isLowMedium = $task->task_level_id != 3;
            if ($task->timeLog) {
                if ($isLowMedium && $task->timeLog->duration > $task->taskLevel->duration) {
                    $duration = $task->taskLevel->duration;
                } else {
                    $duration = $task->timeLog->duration_seconds;
                }
                $totalWorkDuration += $duration;
            }
        }

        return [
            $tasks->count(),
            number_format(($totalWorkDuration / (187 * 3600)) * 100, 2)
        ];
    }

    private function getDayOff($employee){
        $currentYear = now()->year;
        $yearStart = Carbon::create($currentYear, 1, 1);
        $yearEnd = Carbon::create($currentYear, 12, 31);

        $leaves = Administration::where('employee_id', $employee->id)
            ->where(function($query) use ($yearStart, $yearEnd) {
                $query->whereBetween('start_date', [$yearStart, $yearEnd])  // Starts this yearEnd
                    ->orWhereBetween('end_date', [$yearStart, $yearEnd])  // Ends this yearEnd
                    ->orWhere(function($q) use ($yearStart, $yearEnd) {
                        $q->where('start_date', '<', $yearStart)
                            ->where('end_date', '>', $yearEnd);  // Spans entire yearEnd
                    });
            })
            ->get();

        $totalLeaveDays = 0;
        foreach ($leaves as $leave) {
            $startDate = Carbon::parse($leave->start_date)->max($yearStart);
            $endDate = Carbon::parse($leave->end_date)->min($yearEnd);
            $totalLeaveDays += $startDate->diffInDays($endDate) + 1; // +1 to include both start and end duration_seconds
        }

        return $totalLeaveDays;
    }
}
