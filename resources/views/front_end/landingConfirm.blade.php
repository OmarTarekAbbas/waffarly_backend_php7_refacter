@extends('front_end.landing_template')

@section('content')

<body>
<div class="content">
<center style="padding-top: 10px">
  <div class="container">
  <div class="pd_page">
  <div class="clearfix"></div>
      <form action="popup.html" style=" background-image: linear-gradient(rgba(255, 255, 255, 0.2), black), url(landing_page/img/poster-islamic.png);">
    <div class="form-group">
        <p>أدخل رقم هاتفك:</p> 
        <input type="text" id="msisdn" name="msisdn" placeholder="" value="" class="form-control center-block margb" style="direction: ltr; width: 200px"  >
        <input type="submit" value="إشترك" class="btn" style=" background-color: #009047; color: white; width: 100px; height: 50px; font-size: 200%;"/>
 
    </div>
    </form>


<div class="dis">
  <ul>
    <li>تكلفة الاشتراك لعملاء اورنج 2 جنية يوميا و لعملاء فودافون 2 جنيه يوميا</li>
    <li>لإلغاء الإشتراك بإرسال رسالة نصية، لمشتركى شبكة اورنج: إرسال رسالة بها كلمة "الغاء" إلى الرقم المجانى 5030  ، لمشتركى شبكة فودافون: ارسال رسالة بها كلمة "ISLAMIC" إلى الرقم المجانى 6699</li>
    <li>برجاء إرسال اى أسئلة أو شكاوى عن الخدمة إلى support@Islamic.com</li>
    <li>عند اشتراكك فى الخدمة سوف تستمتع بعدد غير محدود من الادعيه،اوالاناشيد،الدروس الاسلاميه،والعديد من الخدمات</li>
    <li>في حالة عدم وجود 2 جنيه في رصيدكم الحالي سيتم خصم 150 قرش أو 100 قرش من الرصيد المتاح للحفاظ على استمرارية الإشتراك فى الخدمة.</li>
    <li>فى حالة عدم وجود رصيد كافى من الوارد تحصيل قيمة الأشتراك بأثر رجعى</li>
  </ul>
</div>


</div>
  </div>
</center>
  
</div>

@include('partial.front_modal')

{{--<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">مشترك بالفعل</h4>
            </div>
            <div class="modal-body">
                <p>عزيزى المستخدم، أنت بالفعل مشترك فى الخدمة ويمكنك الاستمتاع بها من خلال الرابط المرسل سابقا الى هاتفك الخاص ، ويمكنك إعادة إرسالة مرة أخرى من خلال الرابط التالى</p>
                <p><a href="#" style="font-weight: bold">إعادة إرسال رابط الخدمة</a></p>
            </div>
        </div>
    </div>
</div>--}}


</body>

@stop





@section('modal_show')
<script type="text/javascript">
    $(window).ready(function(){
        $('#myModal').modal('show');
    });
</script>
@stop
