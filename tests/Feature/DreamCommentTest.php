<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Faker\Factory;
use App\User;
use App\Models\DreamComment;
use App\Models\Dream;
use App\Jobs\DreamCommentJob;

class DreamCommentTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->seedDream();
    }

    /**
     * @group dream_comment
     */
    public function test_user_can_submit_comment()
    {
        $user = User::find(1);
        $dream = Dream::find(1);
        $faker = Factory::create();
        $postData = [
          'body' => $faker->sentence,
          'dream_id' => $dream->id,
          'user_id' => $user->id,
          'parent_id' => 0,
        ];
        Bus::fake();
        $this->actingAs($user, 'api')
            ->json('POST', '/api/comment', $postData)
            ->assertStatus(200);
    }

    /**
     * @group dream_comment
     */
    public function dream_comment_job()
    {
        $comment = DreamComment::find(1);
        $user = User::find(1);
        $index = 'index';
        $this->actingAs($user, 'api');

        Bus::fake();
        Notification::fake();
        Bus::assertDispatched(DreamCommentJob::class, function ($job) use ($comment, $index) {
            return $job->comment->id === $comment->id;
        });
    }

    private function seedDream()
    {
        $user = factory(User::class)->create([
          'is_active' => 1
        ]);

        $dream = factory(Dream::class)->create([
          'user_id' => $user->id
        ]);

        $comment = factory(DreamComment::class)->create([
          'dream_id' => $dream->id,
          'user_id' => $user->id,
        ]);
    }
}
