<?php

namespace App\Jobs;

use App\Mail\ProjectCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Batchable;

class BroadcastEmailJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $employee;
    public $tries = 3;  // Number of retry attempts

    public function __construct($project, $employee)
    {
        $this->project = $project;
        $this->employee = $employee;
    }

    public function handle()
    {
        Mail::to($this->employee->work_email)
            ->send(new ProjectCreated($this->project, $this->employee));
    }

    public function failed($exception)
    {
        Log::error("Failed to send project creation email to {$this->employee->work_email}: " . $exception->getMessage());
    }
}