@extends('mobilysa.arabic.master')
<?php
$baseUrl = '2';
$englishUrl = '2';
?>
@section('language')

@stop
@section('title')
<title>خدمه وفرلي</title>
@stop

@section('serviceLogo')
    <li class="service-logo make-sticky cf">
        <div class="logo-text">
            <h1 class="flex-col-3">اشتراك</h1>
        </div>
        <div class="logo-img">
            <a href='{{url("$baseUrl/")}}'><img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')
    <section class="subscribe main-container-wrapper">
        <a class="form-btn show-terms">شروط الاشتراك</a>
        <div class="check-terms">
            <ul class="terms">
                <p>عن طريق الاشتراك في الخدمة، يتم قبول جميع شروط و أحكام الخدمة وتفويض اوريدو لتبادل رقم الجوال الخاص بك مع شريكنا IVAS ، الذي يدير خدمة الاشتراك</p>

                <li>
                    <ul>
                        <p>يمكنك الاختيار من بين الخيارات التالية للاشتراك في خدمة العفاسي:</p>
                        <li>للاشتراك في الخطة اليومية، قم بإرسال  afasy d إلى 92815
                        </li>
                        <li>للاشتراك في الخطة الأسبوعية،  قم بإرسال  afasy  إلى 92815
                        </li>
                    </ul>

                </li>



                <li>يتمتع المستخدم الجديد ب7 أيام مجانا عند التنشيط. يرجى ملاحظة أنه إذا كنت تمتعت بالفعل بالفترة المجانية في الماضي، سيتم محاسبتك وفقا لخطة الاشتراك التي قمت بتحديدها.</li>

                <li>يتم تجديد اشتراكك في خدمة العفاسي تلقائيا، حتى تقوم بإلغاء هذه الخدمة.
                </li>

                <li>عن طريق الاشتراك في خدمة العفاسي، تقبل أن تتلقى تجديد وتوصية المحتوى من خلال الرسائل القصيرة.
                </li>

                <li>تطبق رسوم البيانات لتصفح وتنزيل محتويات على هذه البوابة.
                </li>

                <li>إذا كنت ترغب في تعطيل أو إلغاء الاشتراك من خدمة، قم بإرسال UNSUB إلى 92815.
                </li>

                <li>إذا كنت من مستخدمي جهاز IOS،  تحميل أفلام و نغمات غير مسموح، ولكن يمكنك المشاهدة على جهازك.</li>

                <li>إذا كان لديك محاولات تجديد الاشتراك غير ناجحة لمدة 30 يوما في صف واحد، وبعد ذلك سيتم إلغاء تنشيط اشتراكك تلقائيا في يوم 31.
                </li>

                <li>للاستفادة من هذه الخدمة، يجب على المرء أن يكون أكثر من 18 سنة أو حصلت على موافقة أهلك أو الشخص المخول لدفع فاتورة المحمول
                </li>
            </ul>
            <!--<form>
                <input type="checkbox"/>
                <label>أوافق على كافة الشروط واﻷحكام</label>

            </form>-->
        </div><!-- end check terms-->

        <div class="subscriber-wrapper">
            <div class="daily-plan">

                <a href="{{url($baseUrl.'/subscribeD')}}" class="form-btn" onclick="return confirm('هل أنت موافق على كافة الشروط واﻷحكام ؟')">اشترك فى النظام اليومى مقابل ٦٦ هللة</a>

            </div>

            {{--<div class="weekly-plan">
                <!--<h3>الخطة الأسبوعية</h3>-->
               <a href="{{url($baseUrl.'/subscribeW')}}" class="form-btn" onclick="return confirm('هل أنت موافق على كافة الشروط واﻷحكام ؟')">اشترك فى النظام اليومى مقابل 7 ريال قطرى</a>


            </div>--}}

        </div><!-- end subscribe wrapper -->
    </section>
@stop
