<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Employee;
use App\Models\ProjectLevel;
use App\Models\ProjectStatus;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'project_level_id', 'project_status_id'];

    public function level()
    {
        return $this->belongsTo(ProjectLevel::class, 'project_level_id');
    }

    // Relasi dengan ProjectStatus
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    // Relasi many-to-many dengan Employees melalui tabel pivot project_employees
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employees');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
