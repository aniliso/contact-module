@extends('layouts.master')

@section('content')

    <div class="container">
    <div class="white-space space-big"></div>

    <div class="row">
        <div class="col-md-6">
            <h3 class="fancy-title"><span>İletişim Bilgileri</span></h3>
                <ul class="list-default fa-ul">
                    <li><span class="fa-li fa fa-phone color-default"></span>{{ setting('theme::phone') }}</li>
                    <li><span class="fa-li fa fa-envelope color-default"></span>{{ setting('theme::fax') }}</li>
                    <li><span class="fa-li fa fa-clock-o color-default"></span><strong>Monday - Friday:</strong> 09:00 - 18:00</li>
                    <li><span class="fa-li fa fa-map-marker color-default"></span>{{ setting('theme::address') }}</li>
                    <li><span class="fa-li fa fa-envelope color-default"></span>{{ setting('theme::email') }}</li>
                </ul>
            <div class="white-space space-small"></div>
        </div>
        <div class="col-md-6">
            <h3 class="fancy-title"><span>İletişim Formu</span></h3>

            <!-- Form -->
            @include('contact::form')
            <!-- /Form -->

            <div class="white-space space-small"></div>
        </div>
    </div>

    <div class="white-space space-medium"></div>

    </div>

@stop