<?php

namespace Modules\Contact\Http\Controllers\Api;

use Illuminate\Http\Response;
use Modules\Contact\Http\Requests\ApiCallRequest;
use Modules\Contact\Http\Requests\ApiContactRequest;
use Modules\Contact\Jobs\SendContactEmail;
use Modules\Contact\Jobs\SendGuestEmail;
use Modules\Contact\Repositories\ContactRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Setting\Contracts\Setting;
use DB;

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
    public function send(ApiContactRequest $request)
    {
        try {
            if($this->setting->get('contact::contact-email-check')) {
                if($model = $this->contact->findByAttributes(['email'=>$request->get('email')])) {
                    SendContactEmail::dispatch($model);
                    SendGuestEmail::dispatch($model);
                    throw new \Exception(trans('themes::contact.messages.has registered'));
                }
            }
            DB::beginTransaction();
            if($model = $this->contact->create($request->all())) {
                DB::commit();
                SendContactEmail::dispatch($model);
                SendGuestEmail::dispatch($model);
            } else {
                throw new \Exception(trans('themes::contact.messages.error'));
            }
            return response()->json([
                'success' => true,
                'data'    => $model->toJson(),
                'message' => trans('themes::contact.messages.success')
            ]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            \Log::critical($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function call(ApiCallRequest $request)
    {
        try {
            if($this->setting->get('contact::contact-email-check')) {
                if($model = $this->contact->findByAttributes(['email'=>$request->get('email')])) {
                    SendContactEmail::dispatch($model);
                    SendGuestEmail::dispatch($model);
                    throw new \Exception(trans('themes::contact.messages.has registered'));
                }
            }
            DB::beginTransaction();
            if($model = $this->contact->create($request->all())) {
                DB::commit();
                SendContactEmail::dispatch($model);
                SendGuestEmail::dispatch($model);
            } else {
                throw new \Exception(trans('themes::contact.messages.error'));
            }
            return response()->json([
                'success' => true,
                'data'    => $model->toJson(),
                'message' => trans('themes::contact.messages.success')
            ]);
        }
        catch (\Exception $exception) {
            DB::rollBack();
            \Log::critical($exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
