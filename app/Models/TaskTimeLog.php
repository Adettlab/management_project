<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskTimeLog extends Model
{
    protected $fillable = [
        'task_id',
        'started_at',
        'ended_at',
        'duration_seconds',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
