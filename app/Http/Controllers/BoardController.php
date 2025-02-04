<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class BoardController extends Controller
{
  public function index()
  {
    $projects = Project::all();
    return view('board.index', [
      "title" => "Board",
      "active" => "board",
      "projects" => $projects,
    ]);
  }

  public function show(string $id)
  {
    $tasks = Task::with('project', 'taskStatus', 'taskLevel', 'assignedProjectEmployee')
      ->where('project_id', $id)
      ->get();

    return view('board.show', [
      "title" => "Board",
      "active" => "board",
      "tasks" => $tasks
    ],);
  }
}
