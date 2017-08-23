<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Events\Register;
use App\Listeners\AssignRoleProfile;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group register
     */
    public function test_uncomplete_data_cannot_register()
    {
        $postData = [
            'first_name' => 'Dani',
            'email' => 'test@test.com'
        ];
        $this->visit('/')
          ->see('Home')
          ->json('post', '/npp-register', $postData)
          ->assertResponseStatus(422);
    }

    /**
     * @group register
     */
    public function test_user_can_register()
    {
        Event::fake();

        $faker = Factory::create();
        $postData = [
          'first_name' => 'Dani',
          'last_name' => $faker->lastName,
          'dob' => '1981-02-11',
          'gender' => 'Male',
          'email' => 'test@test.com',
          'password' => 'password',
        ];
        $this->visit('/')
          ->see('Home')
          ->json('post', '/npp-register', $postData)
          ->assertResponseStatus(200);

        $user = factory(User::class)->create();
        // Event::assertDispatched(Register::class, function ($e) use ($user) {
        //     return $e->user->id === $user->id;
        // });
    }
}
