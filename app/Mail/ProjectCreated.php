<?php

namespace App\Mail;

use App\Models\Employee;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $project;
    public $employee;

    public function __construct(Project $project, Employee $employee)
    {
        $this->project = $project;
        $this->employee = $employee;
    }

    public function build()
    {
        return $this->subject('New Project Assigned')
                    ->view('emails.project_created')
                    ->with([
                        'projectName' => $this->project->name,
                        'employeeName' => $this->employee->user->name,
                        'startDate' => $this->project->start_date,
                        'endDate' => $this->project->end_date,
                    ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
