<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskTimeLog;
use Carbon\Carbon;

class TaskObserver
{
    private const STATUS_NEW = 1;

    private const STATUS_IN_PROGRESS = 2;

    private const STATUS_REVIEWED = 3;

    private const STATUS_COMPLETED = 4;

    /**
     * Handle the Task "updated" event.
     */
    public function updating(Task $task): void
    {
        try {
            $oldStatus = $task->getOriginal('task_status_id');
            $newStatus = $task->task_status_id;

            if ($oldStatus === $newStatus) {
                return;
            }

            $this->handleTransition($task, $oldStatus, $newStatus);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function handleTransition(Task $task, int $OldStatus, int $newStatus)
    {
        $transition = [
            self::STATUS_NEW => [
                self::STATUS_IN_PROGRESS => fn () => $this->startTask($task),
                self::STATUS_REVIEWED => fn () => $this->updateTaskReview($task),
                self::STATUS_COMPLETED => fn () => $this->updateTakComplete($task),
            ],
            self::STATUS_IN_PROGRESS => [
                self::STATUS_REVIEWED => fn () => $this->updateTaskReview($task),
                self::STATUS_COMPLETED => fn () => $this->updateTakComplete($task),
            ],
            self::STATUS_REVIEWED => [
                self::STATUS_COMPLETED => fn () => $this->updateTakComplete($task),
            ],
        ];

        if (isset($transition[$OldStatus][$newStatus])) {
            $transition[$OldStatus][$newStatus]();
        }
    }

    private function startTask(Task $task)
    {
        TaskTimeLog::create([
            'task_id' => $task->id,
            'started_at' => now(),
        ]);
    }

    private function updateTaskReview(Task $task)
    {
        $activeTime = $this->getActiveTimeLog($task);

        if ($activeTime) {
            $duration = Carbon::parse($activeTime->started_at)->diffInSeconds(now());
            $activeTime->update([
                'duration_seconds' => $duration,
            ]);
        } else {
            $this->startTask($task);
            $activeTime = $this->getActiveTimeLog($task);
            $duration = Carbon::parse($task->created_at)->diffInSeconds(now());
            $activeTime->update([
                'duration_seconds' => $duration,
            ]);
        }
    }

    private function updateTakComplete(Task $task)
    {
        $activeTime = $this->getActiveTimeLog($task);
        if (! $activeTime || ! $activeTime->duration_seconds) {
            $this->updateTaskReview($task);
            $activeTime = $this->getActiveTimeLog($task);
        }

        return $activeTime->update([
            'ended_at' => now(),
        ]);
    }

    private function getActiveTimeLog(Task $task): ?TaskTimeLog
    {
        $activeTime = TaskTimeLog::where('task_id', $task->id)
            ->whereNull('ended_at')
            ->first();

        return $activeTime;
    }
}
