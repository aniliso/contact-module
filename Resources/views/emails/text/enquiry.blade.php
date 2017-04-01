Merhaba

Websiteden bir mesaj aldık, mesajın detayları:

@foreach (config('asgard.contact.config.fields') as $fieldName => $options)
    {{ trans('contact::contacts.form.labels.'.$fieldName) }}    {{ $$fieldName }}
@endforeach
