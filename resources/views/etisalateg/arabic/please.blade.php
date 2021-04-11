@extends('mobilysa.arabic.master')

@section('language')

@stop
@section('title')
    <title>البوابة الاسلامية|اشتراك</title>
@stop

@section('serviceLogo')
    <li class="service-logo make-sticky cf">
    	<div class="logo-text">
        <h1>باقة العفاسى</h1>
        </div>
        <div class="logo-img">
            <a href='{{url("2/")}}'><img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')
    <section class="main-container-wrapper">
        <div><p class="success"> لمشاهدة المزيد ولاستلام أدعية وأناشيد يوميا وكول تون مجانى ومكالمات من الشيخ مشارى راشد العفاسى</p></div>
        <div class="form">
            <a class="form-btn subs" href="tel:*7777%23"><strong>اضغط هنا </strong> واشترك مجانا لمدة 3 أيام</a>
        </div>
    </section>
@stop