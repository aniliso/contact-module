<?php namespace Modules\Contact\Http\Controllers;

use Modules\Contact\Entities\Subject;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Jobs\SendContactEmail;
use Modules\Contact\Jobs\SendGuestEmail;
use Modules\Contact\Repositories\ContactRepository;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Setting\Contracts\Setting;
use Breadcrumbs;
use DB;

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
     * @var Subject
     */
    private $subject;

    /**
     * ContactController constructor.
     * @param Setting $setting
     */
    public function __construct(
        Setting $setting,
        ContactRepository $contact,
        Subject $subject
    )
    {
        parent::__construct();
        $this->setting = $setting;
        $this->contact = $contact;
        $this->subject = $subject;

        view()->share('subjects', $this->subject->list());
    }

    public function index()
    {
        $this->setTitle(trans('themes::contact.title'))
             ->setDescription(trans('themes::contact.description'));

        /* Start Seo */
        $title = trans('themes::contact.title');
        $url   = localize_trans_url($this->locale, 'contact::routes.contact');

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

    /**
     * @param ContactRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function send(ContactRequest $request)
    {
        try {
            DB::transaction(function() use($request){
                if($contact = $this->contact->create($request->all())) {
                    SendContactEmail::dispatch($contact);
                    SendGuestEmail::dispatch($contact);
                } else {
                    throw new \Exception(trans('contact::contacts.messages.create error'));
                }
            });
            return redirect($request->get('from'))->withSuccess(trans('contact::contacts.messages.send success'));
        }
        catch (\Exception $exception) {
            DB::rollBack();
            return redirect($request->get('from'))->withErrors($exception->getMessage());
        }
    }
}
