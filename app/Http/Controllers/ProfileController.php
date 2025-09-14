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

class ProfileController extends Controller
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

    [$sumtask] = $this->getTotalTask($user->employee->id);

    return view('profile.show', [
      'title' => 'Profile',
      'active' => 'users',
      'user' => $user,
      'sumProjects' => $projects->count(),
      'sumTasks' => $sumtask,
     
    ]);
  }

  private function getTotalTask($userID)
  {
    $tasks = Task::with(['taskLevel', 'timeLog'])
      ->where('task_status_id', 4)
      ->whereHas('assignedProjectEmployee', function ($query) use ($userID) {
        $query->where('employee_id', $userID);
      })
      ->get();
    

    return [
      $tasks->count()
    ];
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

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id) {}
}
