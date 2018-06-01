<html>
    <body>
        <p>Merhaba</p>
        <p>Web sitenizden bir mesaj aldık, mesajın detayları:</p>

        @foreach (config('asgard.contact.config.fields') as $fieldName => $options)
            <p><strong>{{ trans('contact::contacts.form.'.$fieldName) }}</strong>: {{ nl2br($contact->{$fieldName}) }}</p>
        @endforeach

        <hr />
        <p>En kısa zamanda müşterinizle/web sitesi ziyaretçinizle temasa geçerek bilgi isteğini karşılayınız.</p>
        <p style="color:red;"><strong>Formun gönderildiği tarih/saat:</strong> {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }}</p>
        <p style="color:red;"><strong>Formu Gönderen IP :</strong> {{ $contact->ip }}</p>
    </body>
</html>