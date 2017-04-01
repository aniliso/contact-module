<?php namespace Modules\Contact\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class ContactRequest extends BaseFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return config('asgard.contact.config.rules');
    }

    public function attributes()
    {
        return trans('contact::contacts.form');
    }

    public function messages()
    {
        return trans('validation');
    }
}