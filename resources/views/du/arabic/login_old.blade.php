@extends('etisalateg.arabic.master')

@section('title')
    <title> وفرلي</title>
@stop

@section('serviceLogo')
    <li class="service-logo cf">
    	<div class="logo-text">
        <h1 class="flex-col-3">
            @if(Session::has('Status'))

        <p class="error">{{Session::get('Status')}}</p>
    @endif</h1>
        </div>
        <div class="logo-img RotateLogo2">
            <a href='{{url("Session::get('OpID')/")}}'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop

@section('content')

@stop
