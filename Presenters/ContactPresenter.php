<?php namespace Modules\Contact\Presenters;

use Laracasts\Presenter\Presenter;
use Modules\Contact\Entities\Subject;

class ContactPresenter extends Presenter
{
    /**
     * Get a bootstrap label of the contact is online or offline
     * @return string
     */
    public function onlineLabel()
    {
        if ($this->entity->online) {
            return '<span class="label label-success">Online</span>';
        }

        return '<span class="label label-default">Offline</span>';
    }

    public function subjectTitle()
    {
        return @(new Subject)->getSubject($this->entity->subject)['title'];
    }

    public function subjectEmail()
    {
        $email = @(new Subject)->getSubject($this->entity->subject)['email'];
        return isset($email) ? trim($email) : setting('contact::contact-to-email', locale());
    }
}
