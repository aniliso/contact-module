<?php

namespace Modules\Contact\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Response;
use Modules\Contact\Http\Requests\CallRequest;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Jobs\SendContactEmail;
use Modules\Contact\Jobs\SendGuestEmail;
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
          SendContactEmail::dispatch($model)
              ->delay(Carbon::now()->addSecond(10));

          SendGuestEmail::dispatch($model)
              ->delay(Carbon::now()->addSecond(15));

//        \Mail::to(setting('contact::contact-to-email', locale()))->queue((new ContactNotified($model))->delay(30));
//        \Mail::to($model->email)->queue((new GuestNotified($model))->delay(60));
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function call(Mailer $mailer, CallRequest $request)
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
}
