<html>
    <body>
        <p>Merhaba</p>
        <p>Websiteden bir mesaj aldık, mesajın detayları:</p>

        @foreach (config('asgard.contact.config.fields') as $fieldName => $options)
            <p><strong>{{ trans('contact::contacts.form.'.$fieldName) }}</strong>: {{ nl2br($$fieldName) }}</p>
        @endforeach
    </body>
</html>