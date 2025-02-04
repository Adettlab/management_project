<?php

namespace App\Http\Controllers;

use App\Models\Administration;
use App\Models\LeaveCategories;
use Illuminate\Http\Request;

class AdministrationController extends Controller
{
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

    public function index(Request $request)
    {
        $leaveCategories = LeaveCategories::select('id', 'name')->get();

        return view('administration.index', [
            'title' => 'Administrations',
            'active' => 'administration',
            'categories' => $leaveCategories
        ]);
    }

    public function store(Request $request)
    {
        $employee = auth()->user()->employee->id;
        $validated = $request->validate([
            'leave_category_id' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'bring_laptop' => 'required|boolean',
            'contacted' => 'required|boolean',
        ]);


        try {
            Administration::create([
                'employee_id' => $employee,
                ...$validated
            ]);

            return redirect()->route('dashboard')->with('success', 'Leave submission created successfully!');
        } catch (\Exception $e) {
            logger()->error('Error creating project: '.$e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Something went wrong. Please try again or contact support']);
        }
    }
}
