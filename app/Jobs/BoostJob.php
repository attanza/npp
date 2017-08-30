<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\User;
use App\Models\Dream;
use App\Models\Boost;
use App\Models\Notification;
use Mail;
use App\Mail\BoostMail;
use App\Events\BoostEvent;
use Carbon\Carbon;
use App\Events\UnreadNotsEvent;

class BoostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dream;
    public $boost;
    public $subject;


    public function __construct(Dream $dream, Boost $boost)
    {
        $this->dream = $dream;
        $this->boost = $boost;
    }

    public function handle()
    {
        // Log::info($boost);
        $this->subject = $this->getFulname($this->boost->user).' memberikan Boost untuk mimpimu';
        $data = [
          'msg' => $this->subject
        ];

        $not = Notification::create([
          'user_id' => $this->dream->user_id,
          'notifiable_id' => $this->boost->id,
          'notifiable_type' => 'App\Models\Boost',
          'data' => json_encode($data)
        ]);
        $bData = [
          'avatar' => $this->boost->user->profile->photo_path,
          'msg' => $this->subject,
          'id' => $not->id,
          'url' => route('dream.show', $this->dream->slug),
          'username' => $this->dream->user->username
        ];
        event(new UnreadNotsEvent($bData));
        // Send Email
        $when = Carbon::now()->addMinutes(5);
        Mail::to($this->dream->user)->later($when, new BoostMail($this->dream, $this->subject));
        // Broadcast Notification
        $avatar = $this->boost->user->profile->photo_path;
        event(new BoostEvent($this->dream->user, $this->subject, $avatar));
    }

    private function getFulname($user)
    {
        return $user->first_name.' '.$user->last_name;
    }
}
