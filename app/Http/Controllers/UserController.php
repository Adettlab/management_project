<?php

namespace App\Http\Controllers;

use App\Models\Administration;
use App\Models\Employee;
use App\Models\ProjectEmployee;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function show()
    {
        $userId = auth()->user()->id;

        $user = User::with('employee')->find($userId);
        $projects = ProjectEmployee::where('employee_id', $user->employee->id)->get();

        [$sumtask, $workhour] = $this->getTotalTaskandWorkDuration($user->employee->id);

        $user->totalWorkDuration = $workhour;

        return view('users.show', [
            'title' => 'Profile',
            'active' => 'users',
            'user' => $user,
            'sumProjects' => $projects->count(),
            'sumTasks' => $sumtask,
            'totalDayOff' => $this->getDayOff($user->employee->id),
        ]);
    }

    private function getTotalTaskandWorkDuration($userID){
        $tasks = Task::with(['taskLevel', 'timeLog'])
            ->where('task_status_id', 4)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereHas('assignedProjectEmployee', function ($query) use ($userID) {
                $query->where('employee_id', $userID);
            })
            ->get();
        $totalWorkHour = 0;

        foreach ($tasks as $task) {
            $isLowMedium = $task->task_level_id != 3;

            if ($task->timelog) {
                if ($isLowMedium && $task->timeLog->duration > $task->taskLevel->duration) {
                    $duration = $task->taskLevel->duration;
                } else {
                    $duration = $task->timeLog->duration_seconds;
                }

                $totalWorkHour += $duration;
            }
        }

        return [
            $tasks->count(),
            number_format(($totalWorkHour / (187 * 3600)) * 100, 2)
        ];
    }

    private function getDayOff($userID){
        $currentYear = now()->year;
        $yearStart = Carbon::create($currentYear, 1, 1);
        $yearEnd = Carbon::create($currentYear, 12, 31);

        $leaves = Administration::where('employee_id', $userID)
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

    public function edit($id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = auth()->user()->id;
        $employee = Employee::where('user_id', $user)->first();

        $validated = $request->validate([
            'work_email' => 'required|email|unique:employees,work_email,'.$employee->id,
            'photo' => 'nullable|image|max:2048', // Maksimum ukuran 2MB
            'nik' => 'nullable|string|max:255|unique:employees,nik,'.$employee->id,
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
