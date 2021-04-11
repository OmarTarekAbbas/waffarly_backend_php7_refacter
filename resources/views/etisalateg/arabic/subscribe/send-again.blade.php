@extends('mobilysa.arabic.master')
<?php
$baseUrl = '2';
$englishUrl = '2';
?>
@section('language')
    <li class="small-4 columns"><a class="lang text-left" href='{{url("$englishUrl/subscribe")}}'>english</a></li>
@stop
@section('title')
<title>خدمه وفرلي</title>
@stop
<style>
.logo-img{
    margin-top: 18%;
    width: 275px;
}

</style>
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
        <!-- if  MSISDN can't be detected -->
        <div class="subscriber-wrapper">
            <div class="error">هناك خطأ في تفعيل الخدمة. نرجو طلب كود تفعيل جديد</div>
            <form method="get" class="form subscribe-form">
                <label for="MSISDN">ادخل رقم المحمول</label>
                <div class="row msisdn-wrapper">
                    <div class="country-code small-3 columns">+974</div>
                    <div class="small-9 columns">
                        <input type="number" name="MSISDN" id="MSISDN"/>
                    </div>
                </div>
                <input class="xs-toggle-btn" type="submit" value="احصل" name="request_pin" />
            </form>
        </div><!-- end subscribe wrapper -->
    </section>
@stop
