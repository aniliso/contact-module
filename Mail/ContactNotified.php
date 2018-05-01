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
        return $this->view('contact::emails.html.enquiry')
                    ->replyTo($contact->email, $contact->first_name.' '.$contact->last_name)
                    ->cc(explode(',', setting('contact::contact-to-cc')))
                    ->subject(setting('contact::contact-to-subject', locale()))
                    ->with(compact('contact'));
    }
}
