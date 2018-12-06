<html>
    <body>
        <p>{{ trans('themes::contact.mail.dear') }} {{ $contact->first_name }} {{ $contact->last_name }}</p>
        <p><strong>{!! trans('themes::contact.mail.message') !!}</strong>: {{ $contact->enquiry }}</p>
        <p style="color:red;"><strong>{!! trans('themes::contact.mail.date') !!}</strong>: {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }}</p>
        <p style="color:red;"><strong>{!! trans('themes::contact.mail.ip') !!}</strong>: {{ $contact->ip }}</p>
        <hr>
        <p>{{ setting('theme::company-name') }}</p>
        <p>{{ setting('theme::address') }}</p>
        <p>{{ setting('theme::phone') }}</p>
        <p>{{ setting('theme::mobile') }}</p>
    </body>
</html>