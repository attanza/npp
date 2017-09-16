<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Bus;
use App\Jobs\BoostJob;
use Faker\Factory;
use App\User;
use App\Models\Profile;
use App\Models\Dream;
use App\Models\Boost;

class BoostTest extends TestCase
{
    use DatabaseMigrations;

    protected $user1;
    protected $user2;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
        $user = $this->createUsers();
        $this->user1 = $user[0];
        $this->user2 = $user[1];
    }

    /**
     * @group boost
     */
    public function test_user_can_boost_another_user()
    {
        Bus::fake();
        $response = $this->get('/dream/'.$this->user2->dream->slug);
        $response->assertStatus(200);
        $this->actingAs($this->user1, 'api')
            ->json('get', '/api/boost/'.$this->user2->dream->id)
            ->assertStatus(200);
    }

    /**
     * @group boost
     */
    public function test_boost_list()
    {
        $this->get('/dream/'.$this->user2->dream->slug)
          ->assertStatus(200);
        $this->json('post', '/boost/'.$this->user2->dream->id.'/listing')
          ->assertStatus(200);
    }

    private function createUsers()
    {
        $users = [];
        for ($i=1; $i <= 2; $i++) {
            $user = factory(User::class)->create([
              'is_active' => 1
            ]);
            $profile = factory(Profile::class)->create([
              'user_id' => $user->id
            ]);
            $dream = factory(Dream::class)->create([
              'user_id' => $user->id
            ]);
            array_push($users, $user);
        }
        return $users;
    }
}
