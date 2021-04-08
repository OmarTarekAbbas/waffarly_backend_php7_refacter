@extends('front_end.landing_template')

@section('content')

<body>


<div id="new_subscriber" class="modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="new_sub">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">أنت غير مشترك في الخدمة</h5>

                </div>
                <div class="modal-body">
                    للإشتراك اضغط على الزر
                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-success" style="margin: 0 127px;"  onclick="TPay_functions()">إشتراك</button>
                </div>

                <div class="dis">
                    <ul>
                   {{--     <li>تكلفة الاشتراك لعملاء اورنج 2 جنية يوميا  ولعملاء اتصالات 2 جنية يوميا و لعملاء فودافون 2 جنيه يوميا</li>--}}
                        <li>تكلفة الاشتراك لعملاء اورنج 2 جنية يوميا  و لعملاء فودافون 2 جنيه يوميا</li>
                      {{--  <li>لإلغاء الإشتراك بإرسال رسالة نصية، لمشتركى اورنج: إرسال كلمة "stop waffar" إلى الرقم المجانى 5030 ، لمشتركى اتصالات: إرسال "stop waffar" إلى الرقم المجانى 1722 ، لمشتركى شبكة فودافون: ارسال "stop waffar" إلى الرقم المجانى 6699</li>--}}
                        <li>لإلغاء الإشتراك بإرسال رسالة نصية، لمشتركى اورنج: إرسال كلمة "stop waffar" إلى الرقم المجانى 5030  ، لمشتركى شبكة فودافون: ارسال "stop waffar" إلى الرقم المجانى 6699</li>
                        <p>او عن طريق هذا <a href="{{url('unsub')}}"   > الرابط  </a>   </p>
                        <li>برجاء إرسال اى أسئلة أو شكاوى عن الخدمة إلى support@yallawaffar.com</li>
                    </ul>
                </div>



            </div>
        </div></div>
</div>


<div class="content">
<center style="padding-top: 10px">
  <div class="container">
  <div class="pd_page" id="div_wifi_box">
  <div class="clearfix"></div>

    {{--  @include('partial.landing_flash')--}}

{!! Form::open(['url'=>"AddSubscriptionContractRequest",'method'=>'post']) !!}
          <div class="form-group" id="wifi_login_subscribe_form">
              <p>أدخل رقم هاتفك:</p>


              <input name="MSISDN" type="number" placeholder="01XXXXXXXXX"  onKeyPress="if(this.value.length==12) return false;"   required  class="form-control center-block margb" style="direction: ltr; width: 200px"  >

              <select  name="operatorCode" required  class="selectpicker" data-live-search="true" >
                 <option value="" disabled selected>أختر شبكتك</option>
                  <option value="60201" > اورانج - مصر </option>
                  <option value="60202" > فوادفون - مصر </option>
                 {{-- <option value="60203" > اتصالات - مصر</option>--}}

               {{--   <option value="42702" > فوادفون - قطر </option>
                  <option value="42701" > اوريدو - قطر </option>

                  <option value="42505" > جوال - فلسطين </option>
                  <option value="42506" > وطنية - فلسطين </option>
--}}

               </select>

              <input type="submit" value="إشترك" class="btn" style=" background-color: #009047; color: white; width: 100px; height: 50px; font-size: 200%;"/>
              <p style="font-size: 12px !important;">سعر الخدمة 2 جنيها يوميا</p>

          </div>
{!! Form::close() !!}


<div class="dis">
<ul>
<li>تكلفة الاشتراك لعملاء اورنج 2 جنية يوميا  و لعملاء فودافون 2 جنيه يوميا</li>
    <li>لإلغاء الإشتراك بإرسال رسالة نصية، لمشتركى اورنج: إرسال كلمة "stop waffar" إلى الرقم المجانى 5030  ، لمشتركى شبكة فودافون: ارسال "stop waffar" إلى الرقم المجانى 6699</li>
   <p>او عن طريق هذا <a href="{{url('unsub')}}"   > الرابط  </a>   </p>
    <li>برجاء إرسال اى أسئلة أو شكاوى عن الخدمة إلى support@yallawaffar.com</li>
</ul>
</div>


</div>
</div>
</center>

</div>
@include('partial.front_modal')


</body>

@stop


@section('modal_show')
    <script type="text/javascript">
        $(window).ready(function(){
            $('#myModal').modal('show');
        });
    </script>





@section('check_HE')
    <script>

        $(document).ready(function(){
            // $("#new_subscriber").css("display","block");
            // $('#login_form').css("display",'none') ;


            if (window.TPay&&TPay.HeaderEnrichment&&TPay.HeaderEnrichment.enriched()) {  // 1- TPay.HeaderEnrichment.enriched
                TPay.HeaderEnrichment.hasSubscription("", function (hasSub, subId) {  // 2 -TPay.HeaderEnrichment.hasSubscription

                    if (!hasSub) {  // not subscriber  [ new register]
                        $("#new_subscriber").css("display","block");
                        $('#div_wifi_box').css("display",'none') ;
                    }
                    else {   // already subscriber ... so make auto login
                        alert("انت مشترك بالفعل جاري التحويل");
                        $("#new_subscriber").css("display","none");


                        login_data = {"contract_id":subId,"_token":"{{csrf_token()}}"} ;
                        // alert(subId) ;
                        $.ajax({
                            method : "POST",
                            url : "{{url('/login_with_contract_id')}}",
                            data : login_data ,
                            success : function(result)
                            {
                                if(result.result==true)
                                    window.location.href = "{{url('/')}}" ;
                                else
                                {
                                    $('#wifi_login_subscribe_form').css("display",'block') ;
                                    alert("Error while automatic login") ;
                                }
                            }
                        });
                    }
                });
            }else{
             //   alert("HE is not enable");
                $("#new_subscriber").css("display","none");
                $("#div_wifi_box").css("display","block");

            }
        });

    </script>
@stop


@stop