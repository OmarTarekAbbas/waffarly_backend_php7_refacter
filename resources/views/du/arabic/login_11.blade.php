@extends('etisalateg.arabic.master')

@section('title')
    <title>خدمه وفرلي</title>
@stop

@section('serviceLogo')
    <li class="service-logo cf">
    	<div class="logo-text">
        <h1 class="flex-col-3"><a href="#">خدمه وفرلي</a></h1>
        </div>
        <div class="logo-img RotateLogo2">
            <a href='{{url("Session::get('OpID')/")}}'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop

@section('content')
<section class="main-container-wrapper">




    <!--<a href="#" class="js-modal-show button-primary">للدخول</a>-->
       @if(Session::has('Status'))
        <div class="l-modal js-modal-shopify is-shown--off-flow">
  <div class="l-modal__shadow js-modal-hide"></div>
  <div class="c-popup l-modal__body">
    <h3 class="c-popup__title">{{Session::get('Status')}}</h3>
  </div>
</div>
    @endif




</section><!-- end main container wrapper -->
@stop
