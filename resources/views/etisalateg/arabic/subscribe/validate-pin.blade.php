@extends('etisalateg.arabic.master')
<?php
$baseUrl = '2';
$englishUrl = '/1/en';
?>
@section('language')

@stop
@section('title')
<title>خدمه وفرلي</title>
@stop

@section('serviceLogo')
    <li class="cf service-logo make-sticky">
    	<div class="logo-text">
        <h1>اشتراك في خدمة وفرلي</h1>
       </div>
        <div class="logo-img">
            <a href='{{url("$baseUrl/")}}'><img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')

        @if(Session::has('success'))
            <div style="text-align: center;width: 100%;padding-top: 10px;color: green;">
                <strong>نجاح !</strong> {{ Session::get('success')}}
            </div>
        @elseif(Session::has('failed'))
            <div style="text-align: center;width: 100%;padding-top: 10px;color: red;">
                <strong>خطأ !</strong> {{ Session::get('failed')}}
            </div>
        @endif

        <section class="subscribe main-container-wrapper">
                    <!-- validate pin -->
            <div class="subscriber-wrapper">

                {!! Form::open(['class'=>'form subscribe-form','url'=>url(Session::get('OpID').'/PinValid')]) !!}

                <div>
                    <label for="PIN">ادخل كود التفعيل</label>
                    <input type="number" name="PIN" id="PIN" required />
                </div>
                <input class="xs-toggle-btn" type="submit" value="تفعيل" name="validate" />
                {!! Form::close() !!}

               {{--  {!! Form::open(['class'=>'form subscribe-form']) !!}
                <input type="hidden" name="MSISDN" value="{{substr(session('SMSISDN'),3)}}">
                <input class="xs-toggle-btn" type="submit" value="إعادة ارسال الكود" name="validate" />
                {!! Form::close() !!}
 --}}
            </div><!-- end subscribe wrapper -->
        </section>



@stop
