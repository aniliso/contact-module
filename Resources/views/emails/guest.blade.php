@component('mail::message')

{!! trans('contact::mail.guest.dear', ['name'=>$contact->fullname]) !!}
<p>{!! trans('contact::mail.guest.notice') !!}</p>

@component('mail::table')

|              |              |
|:-------------|:-------------|
@foreach (config('asgard.contact.config.fields') as $fieldName => $options)
| {!! trans('contact::contacts.form.'.$fieldName) !!} | {!! nl2br($contact->{$fieldName}) !!}
@endforeach
| IP | {!! $contact->ip !!} |
| {!! trans('contact::mail.date time') !!} | {!! \Carbon\Carbon::now()->format('d.m.Y H:i') !!} |

@endcomponent

@endcomponent