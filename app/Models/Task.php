<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // Specify the table if it differs from the plural form of the model name
    protected $table = 'tasks';

    // Define which fields can be mass-assigned
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'task_status_id',
        'task_level_id',
        'assigned_project_employee_id',
    ];

    // Define the relationships

    // A task has one timelog

    public function timeLog()
    {
        return $this->hasOne(TaskTimeLog::class);
    }

    // A task has one project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // A task has one status
    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    // A task has one level (priority or difficulty)
    public function taskLevel()
    {
        return $this->belongsTo(TaskLevel::class);
    }

    // A task is assigned to one employee who is part of the project
    public function assignedProjectEmployee()
    {
        return $this->belongsTo(ProjectEmployee::class, 'assigned_project_employee_id');
    }
}
