<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Dream;
use App\Models\DreamComment;
use Illuminate\Support\Facades\Bus;

class ParentCommentTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->seedComment();
    }

    /**
     * @group parent_comment
     */
    public function test_user_can_get_parent_comment_list()
    {
        $user1 = User::find(5);
        $url = '/dream-comments/parent-comments/'.$user1->dream->id.'?page=1';
        $this->actingAs($user1)
            ->json('get', $url)
            ->assertStatus(206);
    }

    /**
     * @group parent_comment
     */
    public function test_user_can_submit_comment()
    {
        Bus::fake();

        $user1 = User::find(5);
        $user2 = User::find(6);
        $url = '/dream-comments/parent-comments/'.$user1->dream->id.'?page=1';
        $postData = [
          'user_id' => $user2->id,
          'parent_id' => 0,
          'dream_id' => $user1->dream->id,
          'body' => 'test'
        ];
        $this->actingAs($user1, 'api')
            ->json('post', '/api/parent-comments', $postData)
            ->assertStatus(201);
    }
    /**
     * @group parent_comment
     */
    public function test_user_can_update_own_comment()
    {
        $user = User::find(6);
        $comment = DreamComment::find(1);
        $faker = Factory::create();
        $postData = [
            'user_id' => $user->id,
            'dream_id' => $comment->dream_id,
            'parent_id' => 0,
            'body' => $faker->sentence
        ];
        $this->actingAs($user, 'api')
            ->json('put', '/api/parent-comments/'.$comment->id, $postData)
            ->assertStatus(200);
    }
    /**
     * @group parent_comment
     */
    public function test_user_cannot_update_other_comment()
    {
        $user = User::find(5);
        $comment = DreamComment::find(1);
        $faker = Factory::create();
        $postData = [
            'user_id' => $user->id,
            'dream_id' => $comment->dream_id,
            'parent_id' => 0,
            'body' => $faker->sentence
        ];
        $this->actingAs($user, 'api')
            ->json('put', '/api/parent-comments/'.$comment->id, $postData)
            ->assertStatus(403);
    }
    /**
     * @group parent_comment
     */
    public function test_cannot_delete_unexist_comment()
    {
        $user = User::find(5);
        $this->actingAs($user, 'api')
            ->json('delete', '/api/comment/10')
            ->assertStatus(400);
    }
    /**
     * @group parent_comment
     */
    public function test_user_can_delete_own_comment()
    {
        $user = User::find(6);
        $this->actingAs($user, 'api')
            ->json('delete', '/api/comment/1')
            ->assertStatus(200);
    }
    /**
     * @group parent_comment
     */
    public function test_user_cannot_delete_other_comment()
    {
        $user = User::find(4);
        $this->actingAs($user, 'api')
            ->json('delete', '/api/comment/1')
            ->assertStatus(403);
    }
    /**
     * @group parent_comment
     */
    public function test_dream_owner_can_delete_comment()
    {
        $user = User::find(5);
        $this->actingAs($user, 'api')
            ->json('delete', '/api/comment/1')
            ->assertStatus(200);
    }

    private function seedComment()
    {
        $user1 = User::find(5);
        $user2 = User::find(6);

        for ($i=01; $i < 6; $i++) {
            factory(DreamComment::class)->create([
              'user_id' => $user2->id,
              'parent_id' => 0,
              'dream_id' => $user1->dream->id
            ]);
        }
    }
}
