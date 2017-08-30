<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationCodeMail;
use Faker\Factory;
use App\User;
use App\Models\Profile;
use App\Events\Register;
use App\Models\Dream;
use App\Models\Activation;
use App\Listeners\AssignRoleProfile;
use App\Listeners\CreateActivation;

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
        $this->get('/')
          ->assertSee('Home');

        $response = $this->json('post', '/npp-register', $postData);
        $response->assertStatus(422);
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
        $this->get('/')
          ->assertSee('Home');

        $response = $this->json('post', '/npp-register', $postData);
        $response->assertStatus(200);
    }

    /**
     * @group register
     */
    public function test_register_event()
    {
        Event::fake();
        Mail::fake();
        $user = factory(User::class)->create();
        $event = new Register($user);
        $listener = new AssignRoleProfile();
        $listener->handle($event);
        $profile = Profile::where('user_id', $user->id)->first();
        $dream = Dream::where('user_id', $user->id)->first();

        $this->assertSame($profile->id, $event->user->profile->id);
        $this->assertSame($dream->id, $event->user->dream->id);
    }

    /**
     * @group register
     */
    public function test_activation_in_register_event()
    {
        Event::fake();
        Mail::fake();
        $user = factory(User::class)->create();

        $event = new Register($user);
        $listener = new CreateActivation();
        $listener->handle($event);
        $activation = Activation::where('user_id', $user->id)->first();

        $this->assertSame($activation->id, $event->user->activation->id);

        Mail::assertSent(ActivationCodeMail::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });

        Mail::assertSent(ActivationCodeMail::class, function ($mail) use ($user) {
           return $mail->hasTo($user->email);
       });
    }
}
// use App\Events\Users\SignedIn;
// use App\Listeners\Users\SignedInListener;
// use App\Models\User;
// use Carbon\Carbon;
// use Illuminate\Http\Request;

// class UsersSignedInListenerTest extends TestCase
// {
//     public function setUp()
//     {
//         parent::setUp();
//
//         $this->carbon = Mockery::mock(Carbon::class);
//         $this->request = Mockery::mock(Request::class);
//         $this->user = Mockery::mock(User::class)->makePartial();
//     }
//
//     /**
//      * Test event listener set users last signin and active timestamps and
//      * IP address.
//      */
//     public function testHandle()
//     {
//         $time = time();
//         $ip = '127.0.0.1';
//
//         $this->carbon->shouldReceive('now')->once()->andReturn($time);
//         $this->request->shouldReceive('ip')->once()->andReturn($ip);
//         $this->user->shouldReceive('save')->once()->andReturn(true);
//
//         $listener = new SignedInListener($this->carbon, $this->request);
//
//         $listener->handle(new SignedIn($this->user));
//
//         $this->assertSame($time, $this->user->last_signin_at);
//         $this->assertSame($time, $this->user->last_active_at);
//         $this->assertSame($ip, $this->user->ip);
//     }
// }
