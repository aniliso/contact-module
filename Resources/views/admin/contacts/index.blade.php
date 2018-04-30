@extends('layouts.master')

@php $fillables = collect(app(\Modules\Contact\Entities\Contact::class)->getFillable()); @endphp

@section('content-header')
    <h1>
        {{ trans('contact::contacts.title.contacts') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ URL::route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('contact::contacts.title.contacts') }}</li>
    </ol>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="btn-group pull-right" style="margin: 0 15px 15px 0;">
                    <!--<a href="{{ URL::route('admin.contact.contact.create') }}" class="btn btn-primary btn-flat" style="padding: 4px 10px;">
                        <i class="fa fa-pencil"></i> {{ trans('contact::contacts.button.create contact') }}
                    </a>-->
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="data-table table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Id</th>
                            @foreach($fillables->except('enquiry') as $fillable)
                            <th>{{ trans('contact::contacts.form.'.$fillable) }}</th>
                            @endforeach
                            <th>{{ trans('core::core.table.created at') }}</th>
                            <th>{{ trans('core::core.table.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($contacts)): ?>
                        <?php foreach ($contacts as $contact): ?>
                        <tr>
                            <td>
                                {{ $contact->id }}
                            </td>
                            @foreach($fillables->except('enquiry') as $fillable)
                            <td>
                                {!! $contact->{$fillable} !!}
                            </td>
                            @endforeach
                            <td>
                                {{ $contact->created_at }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ URL::route('admin.contact.contact.edit', [$contact->id]) }}" class="btn btn-default btn-flat"><i class="glyphicon glyphicon-search"></i></a>
                                    <button class="btn btn-danger btn-flat" data-toggle="modal" data-target="#confirmation-{{ $contact->id }}"><i class="glyphicon glyphicon-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </div>
    @include('core::partials.delete-modal')
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>c</code></dt>
        <dd>{{ trans('contact::contacts.title.create contact') }}</dd>
    </dl>
@stop

@push('js-stack')
    <script type="text/javascript">
        $( document ).ready(function() {
            $(document).keypressAction({
                actions: [
                    { key: 'c', route: "<?= route('admin.contact.contact.create') ?>" }
                ]
            });
        });
    </script>
    <?php $locale = App::getLocale(); ?>
    <script type="text/javascript">
        $(function () {
            $('.data-table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": '{{ route('admin.contact.contact.index') }}',
                "paginate": true,
                "lengthChange": true,
                "filter": true,
                "sort": true,
                "info": true,
                "autoWidth": true,
                "order": [[ 0, "desc" ]],
                "language": {
                    "url": '<?php echo Module::asset("core:js/vendor/datatables/{$locale}.json") ?>'
                },
                columns: [
                    {data: 'id', name: 'id'},
                    @foreach($fillables->except('enquiry') as $fillable)
                    {data: '{{ $fillable }}', name: '{{ $fillable }}'},
                    @endforeach
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action', orderable: false, searchable: true}
                ],
                stateSave: true
            });
        });
    </script>
@endpush
