<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\Contact;
use Mail;
use App\Mail\contacts\NewContactToSender;
use App\Mail\contacts\NewContactToAdmins;
use App\User;
use Carbon\Carbon;

class NewContactUsMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $newContact;

    public function __construct(Contact $newContact)
    {
        $this->newContact = $newContact;
    }

    public function handle()
    {
        // Send Email to sender
        $when = Carbon::now()->addMinutes(5);
        Mail::to($this->newContact->email)->later($when, new NewContactToSender($this->newContact));
        // Send Email to admins
        $admins = User::whereHas('roles', function ($query) {
            $query->where('slug', 'admin')->orWhere('slug', 'cs');
        })->get();
        Mail::to($admins)->later($when, new NewContactToAdmins($this->newContact));
    }
}
