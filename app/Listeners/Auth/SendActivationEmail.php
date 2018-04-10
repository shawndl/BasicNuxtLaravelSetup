<?php

namespace App\Listeners\Auth;

use App\Events\Auth\UserRequestActivationEmail;
use App\Mail\Auth\ActivationEmail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user)
            ->send(new ActivationEmail($event->user->generateConfirmationToken(),  $event->user));
    }
}
