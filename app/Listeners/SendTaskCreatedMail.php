<?php

namespace App\Listeners;

use App\Events\TaskCreatedEvent;
use App\Mail\taskCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskCreatedMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCreatedEvent $event): void
    {
        Mail::to($event->user->email)->queue(new taskCreatedMail($event->task));
    }
}
