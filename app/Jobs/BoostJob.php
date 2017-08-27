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

class BoostJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $dream;
    public $booster_id;
    public $subject;


    public function __construct(Dream $dream, $booster_id)
    {
        $this->dream = $dream;
        $this->booster_id = $booster_id;
    }

    public function handle()
    {
        // Save Notification in DB
        $boost = $this->getBoostData();
        // Log::info($boost);
        $this->subject = $this->getFulname($boost->user).' memberikan Boost untuk mimpimu';
        $data = [
          'msg' => $this->subject
        ];

        Notification::create([
          'user_id' => $this->dream->user_id,
          'notifiable_id' => $boost->id,
          'notifiable_type' => 'App\Models\Boost',
          'data' => json_encode($data)
        ]);
        // Send Email
        $when = Carbon::now()->addMinutes(5);
        Mail::to($this->dream->user)->later($when, new BoostMail($this->dream, $this->subject));
        // Broadcast Notification
        $avatar = $boost->user->profile->photo_path;
        event(new BoostEvent($this->dream->user, $this->subject, $avatar));
    }

    private function getBoostData()
    {
        $boost = Boost::where('boostable_id', $this->dream->id)
            ->where('boostable_type', 'App\Models\Dream')
            ->where('user_id', $this->booster_id)
            ->first();
        return $boost;
    }

    private function getFulname($user)
    {
        return $user->first_name.' '.$user->last_name;
    }
}
