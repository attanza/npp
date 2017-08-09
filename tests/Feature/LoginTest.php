<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group login
     */
    public function test_uncomplete_credential_cannot_login()
    {
        $this->visit('/')
          ->see('Login')
          ->json('post', '/npp-login')
          ->assertResponseStatus(422);
    }

    /**
     * @group login
     */
    public function test_not_register_user_cannot_login()
    {
        $postData = [
            'email' => 'test@test.com',
            'password' => 'password'
        ];
        $this->visit('/')
          ->see('Login')
          ->json('post', '/npp-login', $postData)
          ->assertResponseStatus(422);
    }

    /**
     * @group login
     */
    public function test_not_activated_user_cannot_login()
    {
        $user = factory(User::class)->create();
        $postData = [
          'email' => $user->email,
          'password' => 'password'
        ];
        $this->visit('/')
          ->see('Login')
          ->json('post', '/npp-login', $postData)
          ->assertResponseStatus(201);
    }

    /**
     * @group login
     */
    public function test_activated_user_can_login()
    {
        $user = User::find(1);
        $postData = [
          'email' => $user->email,
          'password' => 'password'
        ];
        $this->visit('/')
          ->see('Login')
          ->json('post', '/npp-login', $postData)
          ->assertResponseStatus(200);
    }
}
