@extends('front_template')


@section('popup_HE')
    <div id="new_subscriber" class="over">
        <div class="sub">
            <span class="x-icon" id="x_icon">x</span>
            انت غير مشترك بالخدمه
            <br> للاشتراك اضغط علي الزر
            <br><button onclick="TPay_functions()">اشترك</button>

        </div>
    </div>
@stop



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
            {!! Form::open() !!}
            <div class="pages login-page">
                <div class="maleo-card signup animated fadeInUp">
                    <h3 class="maleo-card_title big-title text-center">تسجيل دخول</h3>
                    <div class="form-content">
                        <p class="app-desc" style="text-align: right">من فضلك! أدخل رقم التليفون. ثم أضغط دخول.</p>
                        <div class="input-field with-icon"><span class="icon"><i class="fa fa-phone"></i></span><input id="login" type="number" required name="MSISDN" placeholder="رقم التليفون"></div>
                        <button class="btn-large block margin-bottom" type="submit">دخول</button><span class="app-desc">ليس لديك حساب؟ <a class="primary-text" href="{{url('register')}}">تسجيل جديد</a></span>
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
        <!-- //HERE IS CONTENTS -->
        </div>
    </div>
@stop






@section('check_HE')
    <script>

        $(document).ready(function(){

            if (window.TPay&&TPay.HeaderEnrichment&&TPay.HeaderEnrichment.enriched()) {  // 1- TPay.HeaderEnrichment.enriched
                alert("enriched function result : "+ TPay.HeaderEnrichment.enriched())  ;   // true


                TPay.HeaderEnrichment.hasSubscription("", function (hasSub, subId) {  // 2 -TPay.HeaderEnrichment.hasSubscription
                    if (!hasSub) {
                        //      user is not active subscriber, proceed with subscription
                     //   alert("user is not active subscriber, proceed with subscription from login page");
                        // window.location.href = "{{url('register')}}"
                        $("#new_subscriber").css("display","block");


                    }
                    else {
                        //user is an active subscriber, proceed with login
                       // alert("already subscribed, subscription contract id: " + subId);

                        // call function ajax set session
                        $.ajax({
                            method: "POST",
                            url: "{{url('HE_set_user_session')}}",
                            data: {"contract_id": subId, "operatorCode": 60201},

                            success: function (result) {
                                result = JSON.parse(result);
                                if(result.val == 0 ){
                                 //   alert("fail");
                                }else{
                                  //  alert("success");
                                    window.location.href = "{{url('/')}}"    ;
                                }
                            }
                        }) ;


                    }
                });


            }else{
              //  alert("HE not enabled222")  ;
                $("#new_subscriber").css("display","none");


            }



        });

    </script>
@stop



