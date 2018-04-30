<?php

namespace Modules\Contact\Http\Controllers\Api;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Response;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Repositories\ContactRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Setting\Contracts\Setting;

class PublicController extends BasePublicController
{
    /**
     * @var ContactRepository
     */
    private $contact;
    /**
     * @var Setting
     */
    private $setting;

    public function __construct(ContactRepository $contact, Setting $setting)
    {
        parent::__construct();
        $this->contact = $contact;
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function send(Mailer $mailer, ContactRequest $request)
    {
        try {
            if(!$model = $this->contact->create($request->all())) {
                throw new \Exception(trans('themes::contact.messages.error'));
            } else {
                $mailer->send('contact::emails.html.guest', $model->toArray(), function($message) use ($model) {
                    $message->to(
                        $model->email,
                        $model->first_name.' '.$model->last_name
                    );
                    $message->replyTo($this->setting->get('contact::contact-to-email', locale()), $this->setting->get('contact::contact-to-name', locale()));
                    $message->subject($this->setting->get('contact::contact-to-subject', locale()));
                });
                $mailer->send(config('asgard.contact.config.mail.views'), $request->all(), function ($message) use ($request) {
                    $message->to(
                        $this->setting->get('contact::contact-to-email', locale()),
                        $this->setting->get('contact::contact-to-name', locale())
                    );
                    if(!empty($this->setting->get('contact::contact-to-cc'))) {
                        $message->cc(explode(',', $this->setting->get('contact::contact-to-cc')));
                    }
                    $message->replyTo($request->email, $request->first_name.' '.$request->last_name);
                    $message->subject($this->setting->get('contact::contact-to-subject', locale()));
                });
            }
            return response()->json([
                'success' => true,
                'data'    => json_decode($model),
                'message' => trans('themes::contact.messages.success')
            ]);
        }
        catch (\Exception $exception) {
            \Log::critical($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => trans('themes::contact.messages.error')
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
