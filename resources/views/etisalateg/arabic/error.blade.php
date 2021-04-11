@extends('mobilysa.arabic.master')

@section('language')
    <li class="flex-col-1"><a class="lang text-left" href="#"></a></li>
@stop
@section('title')
    <title>البوابة الاسلامية|خطأ</title>
@stop
@section('serviceLogo')
    <li class="cf service-logo">
    	<div class="logo-text">
        <h1>خطأ</h1>
        </div>
        <div class="logo-img">
            <a href='{{url("2/")}}'><img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')
    <section  id="content-wrapper" class="content-wrapper">
		<div class="error-page arabic">
			<p>
                <?php
                    $Error['nosubd'] = 'أنت غير مشترك فى الخدمة';
                    $Error['pending'] = 'يرجى إعادة شحن رصيدك لتستمع بهذه الخدمة';
                    $Error['unsubd'] = 'يرجى إعادة اشتراكك لتستمتع بهذه الخدمة';
                $Error['rbterror'] = 'حدث خطأ أثناء تنفيذ طلبك برجاء المحاولة فى وقت لاحق';
                    ?>
                @if(isset($error))
                    {{$Error[$error]}}
            </p>
        </div>
                @elseif(Session::has('Status') && session('Status') !== 'active')
                    {{$Error[session('Status')]}}
            </p>
        </div>
        <a class="xs-toggle-btn" href="{{url('2/ar/signup')}}">اشترك</a>
        @endif
    </section>
@stop