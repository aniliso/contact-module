<?php

namespace Modules\Contact\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Mail\ContactNotified;

class SendContactEmail implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Queueable;
    /**
     * @var Contact
     */
    private $contact;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Mail::to(setting('contact::contact-to-email', locale()))->queue(new ContactNotified($this->contact));
    }
}
