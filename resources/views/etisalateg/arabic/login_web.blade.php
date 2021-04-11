@extends('etisalateg.arabic.master')

@section('title')
    <title>خدمه وفرلي</title>
@stop

@section('serviceLogo')
    <li class="service-logo cf">
    <div class="">
            <a href='#0'><img src="{{url('images/logo.png')}}" alt="وفرلى" style="width: 21%;margin-left: 8px;"></a>
    </div>
    <div class="logo-text">
        <h1 class="flex-col-3"><a href="#">خدمه وفرلي</a></h1>
        </div>
        <div class="logo-img RotateLogo2">
            <a href='#0'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>

    </li>
@stop

{{-- @section('content')
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
@stop --}}
@section('content')
<section class="main-container-wrapper">





    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>نجاح !</strong> {{ Session::get('success')}}
        </div>
    @elseif(Session::has('failed'))
        <div style="text-align: center;width: 100%;padding-top: 10px;color: red; direction: rtl">
            <strong>خطأ !</strong> {{ Session::get('failed')}}
        </div>
    @endif



    <a class="form-btn show-terms log">خدمة وفرلي</a>
    <div class="check-terms log">
        {!! Form::open(['id'=>'login-form form','class'=>'login-form form'  ,'name'=>'member_signup', 'url'=>url(Session::get('OpID').'/login_web') ]) !!}

        <label for="MSISDN">ادخل رقم التليفون</label>

        <div class="row msisdn-wrapper">
            <div class="country-code small-3 columns">+20</div>
            <div class="small-9 columns">
                <input type="number" name="MSISDN" value="{{ $phone_number }}" id="MSISDN" required=""  />
            </div>
        </div>


        <input class="xs-toggle-btn" type="submit" value="دخول" name="login" />
        {!! Form::close() !!}
    </div>
    {{--
      <div class="form">

          <a class="form-btn subs" style="background: #e6e6e6;" href="{{url(Session::get('OpID').'/subscribe')}}">    العملاء الجدد  </a>
    </div>
       --}}

</section>
@stop
@section('script')

@if(app('request')->input('msisdn'))
<script>
  window.onload = function(){
    document.forms['member_signup'].submit();
  }
  </script>
@endif

@endsection
