@extends('etisalateg.arabic.master')

@section('title')
    <title>البوابة وفرلي |شروط الاشتراك</title>
@stop

@section('serviceLogo')
    <li class="service-logo cf">
    	<div class="logo-text">
        <h1 class="flex-col-3">الشروط و الأحكام</h1>
        </div>
        <div class="logo-img RotateLogo2">
            <a href='{{url("Session::get('OpID')/")}}'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop

@section('content')
<section class="main-container-wrapper">
    <ul class="terms">
        <p>إشتراكك في هذه الخدمة يعني قبولك لجميع الشروط و الأحكام الخاصة بالخدمة، وتفويض شركة اتصالات مصر لتبادل رقم الجوال الخاص بك مع شريكنا شركة IVAS التي تختص بإدارة هذه الخدمة.</p>

        <li>
        	<ul>
	        	<p>يمكنك الاختيار ما بين الخيارات المتاحة ادناه للاشتراك في خدمة البوابة الاسلامية:</p>
<!--                <li>للاشتراك في النظام اليومي اطلب *92#  او اتصل علي 920</li>-->
                <li>للاشتراك في النظام اليومي اطلب #92*  او اتصل علي 920</li>

        	</ul>

        </li>



        <li>	يتمتع المستخدم الجديد ب 3  أيام مجانا عند تفعيل الخدمة. يرجى ملاحظة أنه إذا كنت تمتعت بالفعل بالفترة المجانية في الماضي، سيتم محاسبتك وفقا لنظام الاشتراك الذي قمت بتحديده.</li>

        <li> 	سيتم تجديد اشتراكك في خدمة البوابة الاسلامية تلقائيا، حتى تقوم بإلغاء تفعيل هذه الخدمة. </li>


    <li>  اشتراكك في خدمة البوابة الاسلامية، يعني موافقتك على استلام تنبيهات التجديد و التوصيات الخاصة بمحتوى الخدمة عن طريق الرسائل القصيرة.</li>



        <li>تطبق الرسوم على البيانات للتصفح ولتنزيل المحتويات المتاحة من هذه التطبيق.</li>





         <li>
        	<ul>
	        	<p>إذا كنت ترغب في تعطيل أو إلغاء الاشتراك من خدمة البوابة الاسلامية برجاء اتباع التعليمات ادناه :</p>
<!--                <li>لإلغاء النظام اليومي، برجاء طلب  *92*0# </li>-->
                <li>لإلغاء النظام اليومي، برجاء طلب  #0*92* </li>

        	</ul>

        </li>


        <li> 	إذا كنت تستخدم جوال يعمل بنظام التشغيل IOS، تحميل الفيديوهات والنغمات غير متاح ، ولكن يمكنك تشغيلها والاستماع إليها على جهازك.</li>

        <li>	إذا لم تنجح المحاولات لتجديد إشتراكك لمدة 30 يوما متتاليا, فسيتم إلغاء تفعيل إشتراكك تلقائيا في اليوم الواحد و الثلاثين.</li>
    </ul>



<!--    <div class="row" id="terms-video">
        <div class="small-12">
            <video style="width:100%;" controls>
              <source src="http://ivas.com.eg/cms/Contents/Al Afasy/20-04-2017/1492716166.mp4" type="video/mp4">
              Your browser does not support HTML5 video.
            </video>
        </div>
    </div>
    -->







</section><!-- end main container wrapper -->
        <script type="text/javascript">
          $('.terms_li').addClass('active_li');
    </script>
@stop
