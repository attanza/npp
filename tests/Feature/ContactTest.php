<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Mail\contacts\NewContactToAdmins;
use App\Mail\contacts\NewContactToSender;
use App\Jobs\NewContactUsMessageJob;
use Faker\Factory;
use App\User;
use App\Models\Contact;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * @group contact
     */
    public function test_user_can_access_contact_page()
    {
        $this->get('/kontak-negeri-para-pemimpi')
        ->assertSee('Nama Anda');
    }

    /**
     * @group contact
     */
    public function test_user_can_submit_messege_at_contact_page()
    {
        $faker = Factory::create();
        $postData = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->e164PhoneNumber,
            'subject' => $faker->sentence,
            'message' => $faker->paragraph
        ];
        // $this->expectsJobs(NewContactUsMessageJob::class);
        $this->withoutJobs();
        $this->post('/kontak-negeri-para-pemimpi', $postData)
            ->assertSessionHas('success', 'Pesan anda sudah terkirim, tim kami akan segera merespon anda');
    }

    /**
     * @group contact
     */
    public function test_new_contact_job()
    {
        Queue::fake();
        Mail::fake();

        $faker = Factory::create();
        $name = "Dani Dadan";
        $postData = [
            'name' => $name,
            'email' => $faker->unique()->safeEmail,
            'phone' => $faker->e164PhoneNumber,
            'subject' => $faker->sentence,
            'message' => $faker->paragraph
        ];

        $this->post('/kontak-negeri-para-pemimpi', $postData)
            ->assertSessionHas('success', 'Pesan anda sudah terkirim, tim kami akan segera merespon anda');

        Queue::assertPushed(NewContactUsMessageJob::class);
    }

    /**
     * @group contact
     */
    public function new_contact_mail_to_admins()
    {
        $contact = factory(Contact::class)->create();
        Mail::fake();
        Mail::assertSent(NewContactToAdmins::class, function ($mail) use ($contact) {
            return $mail->contact->id === $contact->id;
        });
        Mail::assertSent(NewContactToAdmins::class, function ($mail) use ($contact) {
            return $mail->hasTo($contact->email);
        });
    }

    /**
     * @group contact
     */
    public function new_contact_mail_to_sender()
    {
        $contact = factory(Contact::class)->create();
        Mail::fake();
        Mail::assertSent(NewContactToSender::class, function ($mail) use ($contact) {
            return $mail->contact->id === $contact->id;
        });
        Mail::assertSent(NewContactToSender::class, function ($mail) use ($contact) {
            return $mail->hasTo($contact->email);
        });
    }
}
