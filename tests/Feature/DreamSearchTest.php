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

class DreamSearchTest extends TestCase
{
    use DatabaseMigrations;

    private $count;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $this->seedDream();
        $this->count = User::all()->count();
    }

    /**
     * @group dream_search
     */
    public function test_search_by_first_name()
    {
        for ($i=5; $i <= $this->count; $i++) {
          $user = User::find($i);
          $postData = [
              'query' => $user->first_name
          ];
          $this->json('post', '/dream-search', $postData)
              ->assertStatus(200);
        }
    }

    /**
     * @group dream_search
     */
    public function test_search_by_last_name()
    {
        for ($i=5; $i <= $this->count; $i++) {
          $user = User::find($i);
          $postData = [
              'query' => $user->last_name
          ];
          $this->json('post', '/dream-search', $postData)
              ->assertStatus(200);
        }
    }

    /**
     * @group dream_search
     */
    public function test_search_by_email()
    {
        for ($i=5; $i <= $this->count; $i++) {
          $user = User::find($i);
          $postData = [
              'query' => $user->email
          ];
          $this->json('post', '/dream-search', $postData)
              ->assertStatus(200);
        }
    }

    /**
     * @group dream_search
     */
    public function test_search_by_dream()
    {
        for ($i=5; $i <= $this->count; $i++) {
          $user = User::find($i);
          $postData = [
              'query' => $user->dream->dream
          ];
          $this->json('post', '/dream-search', $postData)
              ->assertStatus(200);
        }
    }

    /**
     * @group dream_search
     */
    public function test_search_by_keyword()
    {
        for ($i=5; $i <= $this->count; $i++) {
          $user = User::find($i);
          $postData = [
              'query' => $user->dream->keyword
          ];
          $this->json('post', '/dream-search', $postData)
              ->assertStatus(200);
        }
    }

    private function seedDream()
    {
        for ($i=1; $i < 5; $i++) {
            $user = factory(User::class)->create([
              'is_active' => 1
            ]);
            $dream = factory(Dream::class)->create([
              'user_id' => $user->id
            ]);
        }
    }
}
// axios.post('/dream-search', {query: searchQ}).then((resp)=>{
