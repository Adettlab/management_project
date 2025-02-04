<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeManagementController extends Controller
{
  public function index()
  {
    return view('time-management.index', [
      "title" => "Time Management",
      "active" => "time-management"
    ]);
  }
}
