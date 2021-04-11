@extends('mobilysa.arabic.master')

@section('language')

@stop
@section('title')
    <title>البوابة الاسلامية|نسيت الكود</title>
@stop

@section('serviceLogo')
    <li class="service-logo make-sticky cf">
    	<div class="logo-text">
        <h1>طلب كود جديد</h1>
       </div>
        <div class="logo-img">
            <a href='{{url("2/")}}'><img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')
    <section class="subscribe main-container-wrapper">

        <!-- if  MSISDN can't be detected -->
        <div class="subscriber-wrapper">
            {!! Form::open(['class'=>'form subscribe-form']) !!}

                <label for="MSISDN">ادخل رقم المحمول</label>
                <div class="row msisdn-wrapper">
                    <div class="country-code small-3 columns">+966</div>
                    <div class="small-9 columns">
                        <input type="number" name="MSISDN" id="MSISDN"/>
                    </div>
                </div>
                <input class="xs-toggle-btn" type="submit" value="ارسل الكود" name="send" />
            {!! Form::close() !!}
        </div><!-- end subscribe wrapper -->
    </section>
@stop
