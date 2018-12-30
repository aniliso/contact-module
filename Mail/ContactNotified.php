<?php

namespace Modules\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Contact\Entities\Contact;

class ContactNotified extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Contact
     */
    private $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $contact = $this->contact;

        if(setting('contact::contact-to-cc')) {
            $this->cc(explode(',', setting('contact::contact-to-cc')));
        }

        return $this->markdown('contact::emails.contact')
                    ->replyTo($contact->email, $contact->fullname)
                    ->subject(setting('contact::contact-to-subject', locale()))
                    ->with(compact('contact'));
    }
}
