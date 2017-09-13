<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Notification;
use App\Models\DreamComment;

class NotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::find(5);
        $user2 = User::find(6);
        for ($i=1; $i < 21; $i++) {
            $comment = factory(DreamComment::class)->create([
              'user_id' => $user1->id,
              'dream_id' => $user2->dream->id,
              'parent_id' => 0
            ]);

            $not = factory(Notification::class)->create([
              'notifiable_id' => $comment->id,
              'notifiable_type' => 'App\Models\DreamComment',
              'user_id' => $user2->id
            ]);
        }
    }
}
