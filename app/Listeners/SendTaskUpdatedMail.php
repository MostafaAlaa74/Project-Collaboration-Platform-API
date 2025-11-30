<?php

namespace App\Listeners;

use App\Events\TaskUpdatedEvent;
use App\Mail\taskUpdatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskUpdatedMail
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
    public function handle(TaskUpdatedEvent $event): void
    {
        Mail::to($event->user->email)->queue(new taskUpdatedMail($event->task));
    }
}
