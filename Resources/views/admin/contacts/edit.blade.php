@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('contact::contacts.title.edit contact') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ URL::route('admin.contact.contact.index') }}">{{ trans('contact::contacts.title.contacts') }}</a></li>
        <li class="active">{{ trans('contact::contacts.title.edit contact') }}</li>
    </ol>
@stop

@push('css-stack')
    {!! Theme::style('css/vendor/iCheck/flat/blue.css') !!}
@endpush

@section('content')
    {!! Form::open(['route' => ['admin.contact.contact.update', $contact->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>{{ trans('contact::contacts.title.contacts') }} No</th>
                            <td>{{ $contact->id }}</td>
                        </tr>
                        @foreach(app(\Modules\Contact\Entities\Contact::class)->getFillable() as $fillable)
                        <tr>
                            <th class="col-md-2">{{ trans('contact::contacts.form.'.$fillable) }}</th>
                            <td class="col-md-10">{!! $contact->{$fillable} !!}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="box-footer">
                    {{--<button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>--}}
                    {{--<button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>--}}
                    <a class="btn btn-danger pull-right btn-flat" href="{{ URL::route('admin.contact.contact.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'b', route: "<?= route('admin.contact.contact.index') ?>" }
                ]
            });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });

            $('input[type="checkbox"]').on('ifChecked', function(){
                $(this).parent().find('input[type=hidden]').remove();
            });

            $('input[type="checkbox"]').on('ifUnchecked', function(){
                var name = $(this).attr('name'),
                    input = '<input type="hidden" name="' + name + '" value="0" />';
                $(this).parent().append(input);
            });
        });
    </script>
@endpush
