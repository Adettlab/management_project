<?php
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimeManagementController;
use App\Http\Controllers\UserController;
use App\Models\ProjectEmployee;
use Illuminate\Routing\Route as RoutingRoute;



Route::get('/storage-link', function () {
  Artisan::call('storage:link --force');  
  return 'storage link successfully created';
});

Route::get('/', function () {
    return redirect('login');
});


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function () {
  Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::resource('projects', ProjectController::class);
  Route::get('/tasks/all-task', [TaskController::class, 'allTask'])->name('tasks.allTask');
  Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
  Route::get('/tasks/{id}/employees', [TaskController::class, 'getEmployees'])->name('tasks.getEmployees');
  Route::get('/tasks/get-tasks', [TaskController::class, 'getTasks'])->name('tasks.getTasks');
  Route::resource('tasks', TaskController::class);
  Route::resource('activity', ActivityController::class);
  Route::resource('admin', AdminController::class);
  Route::resource('setting', SettingController::class);
  Route::resource('calendar', CalendarController::class);
  Route::resource('time-management', TimeManagementController::class);
  Route::resource('users', UserController::class);
  Route::get('/users/profile', [UserController::class, 'show'])->name('users.profile');
  Route::resource('administration', AdministrationController::class);
});
