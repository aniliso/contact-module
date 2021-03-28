<?php namespace Modules\Contact\Http\Controllers\Admin;

use Modules\Contact\Entities\Contact;
use Modules\Contact\Entities\Subject;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Repositories\ContactRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ContactController extends AdminBaseController
{
    /**
     * @var ContactRepository
     */
    private $contact;

    public function __construct(ContactRepository $contact)
    {
        parent::__construct();
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \View
     */
    public function index()
    {
        $contacts = Contact::query();
        if(request()->ajax()) {
            return \Datatables::of($contacts)
                ->editColumn('subject', function($contact){
                    return $contact->present()->subjectTitle;
                })
                ->addColumn('action', function ($contact) {
                    $action_buttons =   \Html::decode(link_to(
                        route('admin.contact.contact.edit',
                            [$contact->id]),
                        '<i class="fa fa-search"></i>',
                        ['class'=>'btn btn-default btn-flat']
                    ));
                    $action_buttons .=  \Html::decode(\Form::button(
                        '<i class="fa fa-trash"></i>',
                        ["data-toggle" => "modal",
                         "data-action-target" => route("admin.contact.contact.destroy", [$contact->id]),
                         "data-target" => "#modal-delete-confirmation",
                         "class"=>"btn btn-danger btn-flat"]
                    ));
                    return $action_buttons;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('contact::admin.contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \View
     */
    public function create()
    {
        return view('contact::admin.contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactRequest $request
     * @return \Redirect
     */
    public function store(ContactRequest $request)
    {
        $this->contact->create($request->all());

        return redirect()->route('admin.contact.contact.index')->withSuccess(trans('contact::contacts.messages.contact created'));;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Contact $contact
     * @return \View
     */
    public function edit(Contact $contact)
    {
        return view('contact::admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Contact $contact
     * @param  ContactRequest $request
     * @return \Redirect
     */
    public function update(Contact $contact, ContactRequest $request)
    {
        $this->contact->update($contact, $request->all());

        return redirect()->route('admin.contact.contact.index')->withSuccess(trans('contact::contacts.messages.contact updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact $contact
     * @return \Redirect
     */
    public function destroy(Contact $contact)
    {
        $this->contact->destroy($contact);

        return redirect()->route('admin.contact.contact.index')->withSuccess(trans('contact::contacts.messages.contact deleted'));
    }
}
