<?php

namespace Modules\Contact\Http\Controllers\Api;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Response;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Mail\ContactNotified;
use Modules\Contact\Mail\GuestNotified;
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
            if($this->setting->get('contact::contact-email-check')) {
                if($model = $this->contact->findByAttributes(['email'=>$request->get('email')])) {
                    $this->_sendMail($model);
                    return response()->json([
                        'success' => true,
                        'data'    => json_decode($model),
                        'message' => trans('themes::contact.messages.has registered')
                    ]);
                }
            }
            if($model = $this->contact->create($request->all())) {
                $this->_sendMail($model);
            } else {
                throw new \Exception(trans('themes::contact.messages.error'));
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

    private function _sendMail($model)
    {
        \Mail::to($model->email)->send(new GuestNotified($model));
        \Mail::to(setting('contact::contact-to-email', locale()))->send(new ContactNotified($model));
    }
}
