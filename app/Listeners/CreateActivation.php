<?php

namespace App\Listeners;

use App\Events\Register;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Activation;
use Mail;
use App\Mail\ActivationCodeMail;
use App\User;

class CreateActivation implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Register  $event
     * @return void
     */
    public function handle(Register $event)
    {
        // Create Activation
        $activation = Activation::create([
            'user_id' => $event->user->id,
            'code' => str_random(60),
        ]);
        // Send Activation Code via email
        $user = User::with('activation')->find($event->user->id);
        Mail::to($user)->send(new ActivationCodeMail($user));
    }
}
