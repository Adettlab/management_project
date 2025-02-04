<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    // Specify the table if it differs from the plural form of the model name
    protected $table = 'task_statuses';

    // Define which fields can be mass-assigned
    protected $fillable = ['name', 'color'];

    // A task status can have many tasks
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
