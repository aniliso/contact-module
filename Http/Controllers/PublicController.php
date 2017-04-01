<?php namespace Modules\Contact\Http\Controllers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Contact\Http\Requests\ContactRequest;
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
            ->addMeta('robots', "index, follow");

        $this->seoGraph()->setTitle($title)
            ->setUrl($url);

        $this->seoCard()->setType('app');

        foreach (\LaravelLocalization::getSupportedLocales() as $locale => $supportedLocale)
        {
            if($locale == locale()) continue;
            $this->addAlternateUrl($locale, url(getURLFromRouteNameTranslated($locale, 'contact::routes.contact')));
        }
        /* End Seo */

        /* Start Breadcrumbs */
        Breadcrumbs::register('contact', function($breadcrumbs)
        {
            $breadcrumbs->push(trans('themes::contact.title'), route('contact'));
        });
        /* End Breadcrumbs */

        return view('contact::index');
    }

    public function send(Mailer $mailer, ContactRequest $request)
    {
        $mailer->send(config('asgard.contact.config.mail.views'), $request->all(), function ($message) {
            $message->to(
                $this->setting->get('contact::contact-to-email', locale()),
                $this->setting->get('contact::contact-to-name', locale())
            );
            $message->subject($this->setting->get('contact::contact-to-subject', locale()));
        });

        //$this->contact->create($request->all());

        return redirect($request->get('from'))->with('contact_form_message', trans('contact::contacts.sent_message'));
    }
}