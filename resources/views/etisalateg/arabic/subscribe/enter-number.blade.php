@extends('etisalateg.arabic.master')
<?php
$baseUrl = Session::get('OpID');
$englishUrl = Session::get('OpID');
?>
@section('language')

@stop
@section('title')
<title>خدمه وفرلي</title>
@stop

@section('serviceLogo')
    <li class="service-logo cf">
    <div class="">
            <a href='#0'><img src="{{url('images/logo.png')}}" alt="وفرلى" style="width: 21%;margin-left: 8px;"></a>
    </div>
    <div class="logo-text">
    <h1 class="flex-col-3" style="color: white"> اشتراك في خدمه وفرلي</h1>
        </div>
        <div class="logo-img RotateLogo2">
            <a href='#0'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>

    </li>
@stop
@section('content')

    <section class="subscribe main-container-wrapper">

         @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>نجاح !</strong> {{ Session::get('success')}}
        </div>
    @elseif(Session::has('failed'))
        <div style="text-align: center;width: 100%;padding-top: 10px;color: red;">
            <strong>خطأ !</strong> {{ Session::get('failed')}}
        </div>
    @endif

        <!-- if  MSISDN can't be detected -->
        <div class="subscriber-wrapper">
            {!! Form::open(['class'=>'form subscribe-form']) !!}

                <label for="MSISDN">ادخل رقم التليفون</label>
                <div class="row msisdn-wrapper">
                    <div class="country-code small-3 columns">+20</div>
                    <div class="small-9 columns">
                        <input type="number" name="MSISDN" id="MSISDN" required=""/>
                    </div>
                </div>
                <input class="xs-toggle-btn" type="submit" value="اشترك" name="subscribe" />
            {!! Form::close() !!}

            <!--<a href="{{url(Session::get('OpID')."/login2")}}" class="xs-toggle-btn"   > تسجيل الدخول </a>-->

        </div><!-- end subscribe wrapper -->
    </section>
@stop
