<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use Faker\Factory;
use App\User;
use App\Models\Profile;
use App\Models\Dream;
use Mail;
use App\Mail\CreateDreamMail;
use Illuminate\Support\Facades\Bus;
use App\Jobs\UploadDreamJob;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use App\Events\UploadDreamEvent;

class DreamTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group dream
     */
    public function test_user_can_visit_bmi_page()
    {
        $this->get('/berjuta-mimpi-indonesia')
            ->assertStatus(200);
    }

    /**
     * @group dream
     */
    public function test_user_can_submit_dream()
    {
        Queue::fake();
        Mail::fake();
        $user = $this->createUser();
        $faker = Factory::create();
        $postData = [
          'dream' => $faker->sentence,
          'keyword' => $faker->word,
          'description' => $faker->paragraph,
        ];

        // Mail::to($user)->send(new CreateDreamMail($user));
        $this->actingAs($user, 'api')
            ->json('post', '/api/dream/'.$user->dream->id, $postData)
            ->assertStatus(200);
        // Perform Send Mail...
        Mail::assertSent(CreateDreamMail::class, function ($mail) use ($user) {
           return $mail->user->id === $user->id;
        });
        // Assert a message was sent to the given users...
        Mail::assertSent(CreateDreamMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /**
     * @group dream
     */
    public function test_user_cannot_submit_other_user_dream()
    {
        $user = $this->createUser();
        $otherUser = $this->createUser();

        $faker = Factory::create();
        $postData = [
          'dream' => $faker->sentence,
          'keyword' => $faker->word,
          'description' => $faker->paragraph,
        ];
        $this->actingAs($user, 'api')
            ->json('post', '/api/dream/'.$otherUser->dream->id, $postData)
            ->assertStatus(403);
    }

    /**
     * @group dream
     */
    public function test_user_can_upload_dream_photo()
    {
        $user = $this->createUser();
        $faker = Factory::create();
        $dream = $user->dream;

        // Fake image
        Bus::fake();
        Event::fake();
        Storage::fake('avatars');
        // $file = UploadedFile::fake()->image('avatar.jpg');
        $imagedata= $faker->imageUrl;
        $base64 = base64_encode($imagedata);

        $postData = [
          'file' => $base64,
        ];

        $this->actingAs($user, 'api')
            ->json('post', '/api/dream/'.$user->dream->id.'/upload', $postData)
            ->assertStatus(200);

        // Perform UploadDreamJob
        Bus::assertDispatched(UploadDreamJob::class, function ($job) use ($dream, $base64) {
            return $job->dream->id === $dream->id;
        });
        // Event::assertDispatched(UploadDreamEvent::class, function ($e) use ($username, $dream_photo) {
        //     return $e->dream_photo === $dream_photo;
        // });
    }

    private function createUser()
    {
        $user = factory(User::class)->create([
          'is_active' => 1,
        ]);

        factory(Profile::class)->create([
          'user_id' => $user->id,
        ]);

        factory(Dream::class)->create([
          'user_id' => $user->id,
        ]);

        return User::with('profile', 'dream')->find($user->id);
    }
}
