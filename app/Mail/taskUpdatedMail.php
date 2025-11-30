<?php

namespace App\Mail;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class taskUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Task $task;
    public Project $project;
    /**
     * Create a new message instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->project = $task->project;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Updated Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.taskUpdated',
            with:[
                'task' => $this->task,
                'project' => $this->project
            ]
        );
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
