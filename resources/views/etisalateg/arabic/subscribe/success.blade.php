@extends('mobilysa.arabic.master')
<?php
$baseUrl = '2';
$englishUrl = '2';
?>
@section('language')

@stop
@section('title')
<title>خدمه وفرلي</title>
@stop

@section('serviceLogo')
    <li class="cf service-logo make-sticky">
    	<div class="logo-text">
        <h1 class="flex-col-3">اشتراك في خدمة وفرلي</h1>
        </div>
        <div class="logo-img">
            <a href='{{url("$baseUrl/")}}'><img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')
    <section class="subscribe main-container-wrapper">
        <div class="subscriber-wrapper">
           <p class="success">تم اشتراكك في خدمة العفاسي بنجاح</p>
        </div><!-- end subscribe wrapper -->
    </section>
@stop
