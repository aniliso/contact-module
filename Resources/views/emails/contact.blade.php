@component('mail::message')
{!! trans('contact::mail.admin.dear', ['company'=>setting('core::site-name')]) !!}
<p>{!! trans('contact::mail.admin.header notice') !!}</p>
@component('mail::table')

|              |              |
|:-------------|:-------------|
@foreach (config('asgard.contact.config.fields') as $fieldName => $options)
| {!! trans('contact::contacts.form.'.$fieldName) !!} | {!! nl2br($contact->{$fieldName}) !!}
@endforeach
| IP | {!! $contact->ip !!} |
| {!! trans('contact::mail.date time') !!} | {!! \Carbon\Carbon::now()->format('d.m.Y H:i') !!} |

@endcomponent

@component('mail::panel')
{!! trans('contact::mail.admin.notice') !!}
@endcomponent

@endcomponent