<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\DreamComment;
use App\Models\Notification;

class NotificationTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->seedNots();
    }

    /**
     * @group notification
     */
    public function test_user_can_access_own_notifications()
    {
        $user = User::find(6);
        $this->actingAs($user)
          ->get('/notifikasi')
          ->assertStatus(200)
          ->assertSee('Notifikasi');
    }

    /**
     * @group notification
     */
    public function test_user_can_see_notification_list()
    {
        $user = User::find(6);
        $url = '/api/notification/listing?page=1';
        $postData = [
          'paginate' => 10,
          'query' => ''
        ];

        $this->actingAs($user, 'api')
          // ->get('/notifikasi')
          ->json('post', $url, $postData)
          ->assertStatus(200);
    }

    /**
     * @group notification
     */
    public function test_user_can_set_notification_read()
    {
        $user = User::find(6);
        $notification = Notification::where('user_id', $user->id)->first();
        $url = '/api/notification/'.$notification->id;

        $this->actingAs($user, 'api')
          // ->get('/notifikasi')
          ->json('put', $url)
          ->assertStatus(200);
    }

    // notification/{id}

    private function seedNots()
    {
        $user1 = User::find(5);
        $user2 = User::find(6);
        for ($i=1; $i < 6; $i++) {
          $comment = factory(DreamComment::class)->create([
            'user_id' => $user1->id,
            'dream_id' => $user2->dream->id
          ]);
          $data = [
            'msg' => $user1->first_name.' memberi Comment'
          ];
          Notification::create([
            'user_id' => $user2->id,
            'notifiable_id' => $comment->id,
            'notifiable_type' => 'App\Models\DreamComment',
            'data' => json_encode($data)
          ]);
        }
    }
}

// $table->increments('id');
// $table->unsignedInteger('user_id')->index();
// $table->integer('notifiable_id');
// $table->string('notifiable_type');
// $table->json('data');
// $table->boolean('read')->default(0);
// $table->timestamp('read_at')->nullable();
// $table->timestamps();
