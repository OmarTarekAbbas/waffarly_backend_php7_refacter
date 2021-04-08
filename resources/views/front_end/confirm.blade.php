@extends('front_template')
@section('front_content')
    <div id="page">
        @extends('top_navbar')

            <div class="content-container">

                @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible">
                         {{ Session::get('success')}}
                    </div>
                @elseif(Session::has('failed'))
                    <div class="alert alert-danger alert-dismissible">
                        {{ Session::get('failed')}}
                    </div>
            @endif

                <!-- HERE IS CONTENTS -->
                <div class="pages signup-page">
                    <div class="maleo-card signup animated fadeInUp">
                        <h3 class="maleo-card_title big-title text-center">تأكيد الاشتراك</h3>
                        {!! Form::open(['url'=>"tpay_subscribe_verify",'method'=>'post']) !!}
                        <div class="form-content">
                            <p class="app-desc" style="text-align: right">من فضلك!  أدخل كود التفعيل </p>
                            <div class="input-field with-icon"><span class="icon"><i class="fa fa-phone"></i></span><input id="signup" type="number" placeholder="كود التفعيل" name="pinCode"  required></div>
                            <button class="btn-large block margin-bottom" type="submit">تفعيل</button><span class="app-desc">لدي حساب؟ <a class="primary-text" href="{{url('login')}}"> دخول</a></span>

                            @if(Session::has('contract_id'))
                                <span class="app-desc"> &nbsp; &nbsp;  <a class="primary-text" href="{{url('sub_pincode_resend')}}">  اعادة ارسال الكود</a></span>
                            @endif

                        </div>
                        {!! Form::close() !!}



                    </div>
                </div>
                <!-- //HERE IS CONTENTS -->
            </div>

    </div>
@stop


