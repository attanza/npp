<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Faker\Factory;
use App\User;
use App\Mail\AfterChangePasswordMail;
use Illuminate\Support\Facades\Mail;

class ChangePasswordTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group change_password
     */
    public function test_user_can_change_password()
    {
        Mail::fake();
        $user = User::find(1);
        $postData = [
          'old_password' => 'password',
          'password' => 'password2',
          'password_confirmation' => 'password2'
        ];
        $this->actingAs($user, 'api')
            ->json('post','/api/reset-password/'.$user->id, $postData)
            ->assertStatus(200);

        Mail::assertSent(AfterChangePasswordMail::class, function ($mail) use ($user) {
            return $mail->user->id === $user->id;
        });

        // Assert a message was sent to the given users...
        Mail::assertSent(AfterChangePasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * @group change_password
     */
    public function test_user_cannot_change_password_if_empty_field()
    {
        Mail::fake();
        $user = User::find(1);
        $postData = [
          'old_password' => '',
          'password' => '',
          'password_confirmation' => ''
        ];
        $this->actingAs($user, 'api')
            ->json('post','/api/reset-password/'.$user->id, $postData)
            ->assertStatus(422);
    }

    /**
     * @group change_password
     */
    public function test_user_cannot_change_password_if_not_confirm()
    {
        Mail::fake();
        $user = User::find(1);
        $postData = [
          'old_password' => 'password',
          'password' => 'password2',
          'password_confirmation' => 'password1'
        ];
        $this->actingAs($user, 'api')
            ->json('post','/api/reset-password/'.$user->id, $postData)
            ->assertStatus(422);
    }

    /**
     * @group change_password
     */
    public function test_user_cannot_change_password_if_old_password_is_wrong()
    {
        Mail::fake();
        $user = User::find(1);
        $postData = [
          'old_password' => 'testPassword',
          'password' => 'password2',
          'password_confirmation' => 'password1'
        ];
        $this->actingAs($user, 'api')
            ->json('post','/api/reset-password/'.$user->id, $postData)
            ->assertStatus(422);
    }
}
