<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Models\Activation;
use Mail;
use App\Mail\ActivationCodeMail;

class ActivationTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group activation
     */
    public function test_user_activation()
    {
        $user = factory(User::class)->create();
        $activation = factory(Activation::class)->create([
          'user_id' => $user->id,
        ]);
        $this->get('/npp-activation/'.$user->email.'/'.$activation->code)
          ->assertRedirect('/')
          ->assertSessionHas('success', 'Akun anda telah diaktifkan, silahkan login.');
    }

    /**
     * @group activation
     */
    public function test_user_activation_with_wrong_email_will_return_error_message()
    {
        $user = factory(User::class)->create();
        $activation = factory(Activation::class)->create([
          'user_id' => $user->id,
        ]);
        $this->get('/npp-activation/test@test.com/'.$activation->code)
          ->assertRedirect('/')
          ->assertSessionHas('error', 'User tidak ditemukan');
    }

    /**
     * @group activation
     */
    public function test_user_activation_with_wrong_code_will_return_error_message()
    {
        $user = factory(User::class)->create();
        $activation = factory(Activation::class)->create([
          'user_id' => $user->id,
        ]);
        $this->get('/npp-activation/'.$user->email.'/hjdkslhf9879pehjhjalkjdfh')
          ->assertRedirect('/')
          ->assertSessionHas('error', 'Kode tidak valid');
    }

    /**
     * @group activation
     */
    public function test_resend_user_activation()
    {
        Mail::fake();

        $user = factory(User::class)->create([
          'email' => 'test@test.com',
          'password' => 'password'
        ]);

        $postData = [
          'email' => 'test@test.com',
          'password' => 'password',
          '_token' => csrf_token()
        ];
        $this->withoutMiddleware()
            ->json('POST', '/npp-activation/resend', $postData)
            ->assertStatus(200)
            ->assertJson([
                'msg' => 'Email akan dikirmkan dalam beberapa saat'
            ]);

        // Perform ActivationCodeMail
        Mail::assertSent(ActivationCodeMail::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });
        // Assert a message was sent to the given users...
        Mail::assertSent(ActivationCodeMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
