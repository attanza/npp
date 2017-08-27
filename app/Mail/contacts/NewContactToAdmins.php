<?php

namespace App\Mail\contacts;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Contact;

class NewContactToAdmins extends Mailable
{
    use Queueable, SerializesModels;

    public $newContact;

    public function __construct(Contact $newContact)
    {
        $this->newContact = $newContact;
    }

    public function build()
    {
        $subject = "Pesan anda telah kami terima ~ Negeri Para Pemimpi";
        return $this->subject($subject)
            ->view('mails.contacts.new_contact_to_admin');
    }
}
