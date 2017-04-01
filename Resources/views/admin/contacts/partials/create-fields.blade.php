<div class="box-body">
    {!! Form::i18nTextarea('body', trans('contact::contacts.form.enquiry'), $errors, $lang) !!}

    {!! Form::i18nCheckbox('online', trans('contact::contacts.title.online'), $errors, $lang) !!}
</div>
