<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group profile
     */
    public function test_user_can_access_own_profile()
    {
        $user = factory(User::class)->create();
        $profile = factory(Profile::class)->create([
          'user_id' => $user->id
        ]);
        $this->actingAs($user)
          ->get('/profile/'.$user->username)
          ->assertResponseStatus(200);
    }

    /**
     * @group profile
     */
    public function test_user_cannot_access_others_profile()
    {
        $user = factory(User::class)->create();
        $other_user = factory(User::class)->create();

        $this->actingAs($user)
          ->get('/profile/'.$other_user->username)
          ->assertRedirectedTo('/')
          ->assertSessionHas('error', 'Akses tidak diperkenankan');
    }

    /**
     * @group profile
     */
    public function test_user_can_edit_own_profile()
    {
        $user = factory(User::class)->create([
          'is_active' => 1
        ]);
        $profile = factory(Profile::class)->create([
          'user_id' => $user->id
        ]);
        $faker = Factory::create();
        $first_name = $faker->firstNameMale;
        $username = $first_name.'-'.time();
        $postData = [
          'first_name' => $first_name,
          'last_name' => $first_name,
          'dob' => '1981-02-11',
          'gender' => 'Male',
          'username' => $username,
          'email' => $faker->unique()->safeEmail,
        ];
        $this->actingAs($user, 'api')
          ->json('put', '/api/profile/'.$user->id, $postData)
          ->assertResponseStatus(200);
    }

    /**
     * @group profile
     */
    public function test_user_can_edit_own_profile_detail()
    {
        $user = factory(User::class)->create([
          'is_active' => 1
        ]);
        $profile = factory(Profile::class)->create([
          'user_id' => $user->id
        ]);
        $faker = Factory::create();
        $first_name = $faker->firstNameMale;
        $username = $first_name.'-'.time();
        $postData = [
          'phone' => $faker->e164PhoneNumber,
          'address' => $faker->address,
          'about' => $faker->paragraph,
          'lat' => $faker->latitude,
          'lng' => $faker->longitude,
        ];
        $this->actingAs($user, 'api')
          ->json('put', '/api/profile/'.$user->id.'/detail', $postData)
          ->assertResponseStatus(200);
    }
}
