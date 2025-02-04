<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskLevel extends Model
{
    use HasFactory;

    // Specify the table if it differs from the plural form of the model name
    protected $table = 'task_levels';

    // Define which fields can be mass-assigned
    protected $fillable = ['name', 'color'];

    // A task level can have many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
