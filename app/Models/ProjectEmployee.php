<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEmployee extends Model
{
    use HasFactory;

    // Specify the table if it differs from the plural form of the model name
    protected $table = 'project_employees';

    // Define which fields can be mass-assigned
    protected $fillable = ['project_id', 'employee_id'];

    // A project_employee belongs to one project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // A project_employee belongs to one employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
