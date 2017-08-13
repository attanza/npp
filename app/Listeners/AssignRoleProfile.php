<?php

namespace App\Listeners;

use App\Events\Register;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\Dream;
use App\Models\Media;
use App\Models\Role;

class AssignRoleProfile implements ShouldQueue
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
        $role = Role::where('slug', 'user')->first();
        DB::table('role_user')->insert([
            'user_id' => $event->user->id,
            'role_id' => $role->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Profile::create([
            'user_id' => $event->user->id
        ]);

        Dream::create([
            'user_id' => $event->user->id
        ]);
    }
}
