<?php

namespace Modules\Contact\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Contact\Entities\Contact;

class GuestNotified extends Mailable
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

        return $this->markdown('contact::emails.guest')
                    ->subject(setting('contact::contact-to-subject', locale()))
                    ->replyTo(setting('contact::contact-to-email', locale()), setting('contact::contact-to-name', locale()))
                    ->with(compact('contact'));
    }
}
