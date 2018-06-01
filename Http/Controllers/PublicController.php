<?php namespace Modules\Contact\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Mail\Mailer;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Jobs\SendContactEmail;
use Modules\Contact\Jobs\SendGuestEmail;
use Modules\Contact\Repositories\ContactRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Setting\Contracts\Setting;
use Breadcrumbs;

class PublicController extends BasePublicController
{
    /**
     * @var Setting
     */
    private $setting;
    /**
     * @var ContactRepository
     */
    private $contact;

    /**
     * ContactController constructor.
     * @param Setting $setting
     */
    public function __construct(Setting $setting, ContactRepository $contact)
    {
        parent::__construct();
        $this->setting = $setting;
        $this->contact = $contact;
    }

    public function index()
    {
        $this->setTitle(trans('themes::contact.title'))
             ->setDescription(trans('themes::contact.description'));

        /* Start Seo */
        $title = trans('themes::contact.title');
        $url   = getURLFromRouteNameTranslated($this->locale, 'contact::routes.contact');

        $this->setTitle($title)
            ->setDescription($title);

        $this->setUrl($url)
            ->addMeta('robots', "index, follow")
            ->addAlternates($this->getAlternateLanguages('contact::routes.contact'));

        $this->seoGraph()->setTitle($title)
            ->setUrl($url);

        $this->seoCard()->setType('app');
        /* End Seo */

        /* Start Breadcrumbs */
        Breadcrumbs::register('contact', function($breadcrumbs)
        {
            $breadcrumbs->push(trans('themes::contact.title'), route('contact'));
        });
        /* End Breadcrumbs */

        return view('contact::index');
    }

    public function send(ContactRequest $request)
    {
        if($contact = $this->contact->create($request->all())) {
            $this->_sendMail($contact);
        }

        return redirect($request->get('from'))->with('contact_form_message', trans('contact::contacts.sent_message'));
    }

    private function _sendMail($model)
    {
        SendContactEmail::dispatch($model)
            ->delay(Carbon::now()->addSecond(10));

        SendGuestEmail::dispatch($model)
            ->delay(Carbon::now()->addSecond(15));
    }
}