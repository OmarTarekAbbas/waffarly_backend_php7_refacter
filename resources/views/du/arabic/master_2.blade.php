<!DOCTYPE html>
<html lang="ar">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="format-detection" content="telephone=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        @yield('title')
        <!-- google fonts -->
        <link href='https://fonts.googleapis.com/css?family=Ubuntu|Cookie' rel='stylesheet' type='text/css'>
        <!-- Bootstrap -->
        <!--<link href="{{ asset('etisalateg/css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">-->

        <!-- Font Awesome icon fonts -->
        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="{{asset('fonts/vendor/font-awesome/css/font-awesome.min.css')}}">
        <!-- My Styles -->
        <link href="{{ asset('etisalateg/css/vendor/grid/css/foundation.css') }}" rel="stylesheet">
        <link href="{{ asset('etisalateg/css/WebApps/ooredoo/afasy/base.css') }}" rel="stylesheet">
        <link href="{{ asset('etisalateg/css/WebApps/ooredoo/afasy/general.css') }}" rel="stylesheet">
         <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/services.css') }}" rel="stylesheet">
        <link href="{{ asset('js/WebApps/ooredoo/slick/slick.css') }}" rel="stylesheet">
        <link href="{{ asset('js/WebApps/ooredoo/slick/slick-theme.css') }}" rel="stylesheet">

        @if(Session::get('OpID') == '15' )
        <link rel="stylesheet" type="text/css" href="{{ asset('css/WebApps/ooredoo/afasy/mobinil.css') }}"/>
        @endif
        <link href="{{ asset('etisalateg/css/WebApps/ooredoo/afasy/arabic.css') }}" rel="stylesheet">

        <!-- link to animate.css -->
        <link href="{{ asset('etisalateg/css/vendor/animate.css') }}" rel="stylesheet">

        <style>
            .toggle-menu li {
                width: 25% !important;
            }
        </style>

        <!-- video js styles link -->
        <link href="{{ asset('js/vendor/video-js/video-js.min.css') }}" rel="stylesheet">
        <script src="{{asset('js/vendor/video-js/video.js')}}"></script>

        <!-- videojs responsive hack -->
        <style>
            .video-js {padding-top: 56.25%}
            .vjs-fullscreen {padding-top: 0px}
            .animated.slideInRight{
                -webkit-animation-duration: .2s;
                animation-duration: .2s;
                -webkit-animation-timing-function:linear;
                -webkit-animation-fill-mode: both;
                animation-fill-mode: both;
            }
        </style>



        <!-- jQuery -->
        <script src="{{asset('js/vendor/jquery-1.11.2.min.js')}}"></script>
        @if(Session::get('OpID') == '15' )
        <script>
$(function () {
    $('.logo-img img').attr('src', 'http://ivas.info/afasy/img/WebApps/ooredoo/afasy/logo_grey.svg');
    $('.logo-text img').attr('src', 'http://ivas.info/afasy/img/WebApps/ooredoo/afasy/logotext_grey.svg');
});

        </script>
        @endif

        <!-- English to Arabic Numbers -->
        <script src="{{asset('js/vendor/persianumber.min.js')}}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        @yield('styles')
        <style>
            .copyright{
                color:#07AED8;
            }
            .ooredoo-logo-img.ivas{
                height: 40px;
                width: auto;
            }
            #popup audio {
                display: none;
            }
            #popup source {
                display :none;
            }
        </style>
    </head>
    <body id="arabic">

        <script>

(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {

        (i[r].q = i[r].q || []).push(arguments)
    }, i[r].l = 1 * new Date();
    a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)

})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');



ga('create', 'UA-50044194-3', 'auto');

ga('send', 'pageview');



        </script>


        <!-- split the body into site wrapper which wraps the content and a menu-wrapper
            for wrapping the navigation menu -->

        <!-- Burger Menu -->
        <div class="menu-container">
            <!-- if the visitor is subscribed show the account summary -->
            <!-- subscriber account summary -->
            <div class="menu-wrapper">
                <div class="categories-wrapper">
                    <!-- if the subscriber is active -->



                    <!-- if the user isn't subscribed show subscribe link -->
                    <!--<a href='{{url("2/subscribe")}}' class="account-summary">
                        <div class="account-summary-wrapper flex-container">
                            <hgroup class="flex-col-3">
                                <h1><div class="flex-container flex-col-3 row-center-vertical"><p>اشتراك</p></div></h1>
                            </hgroup>
                            <div class="flex-col-1 flex-container flex-right"><span class="fa fa-user"></span></div>
                        </div>
                    </a>--><!--end account summary-->

                    <!-- if the MSISDN can't be detected show login form link -->
                    <!--<a href='{{url("2/login")}}' class="account-summary">
                        <div class="account-summary-wrapper flex-container">
                            <hgroup class="flex-col-3">
                                <h1>تسجيل دخول</h1>
                            </hgroup>
                            <div class="flex-col-1 flex-container flex-right"><span class="fa fa-user"></span></div>
                        </div>
                    </a>--><!--end account summary-->

                    <!-- Site navigation and social media -->
                    <ul class="menu-categories">
                        <!-- menu link 1 -->
                        <li class="home_li">
                            <a href='{{url(Session::get('OpID'))}}' class="row">
                                <div class="small-3 columns">
                                    <span class="fa fa-home"></span>
                                </div>
                                <div class="small-9 columns"><p>الرئيسية</p></div>
                            </a>
                        </li>

                        <!-- menu link 2 -->
                        <li class="rbts_li">
                            <a href='{{url(Session::get('OpID')."/all/rbts")}}' class="row">
                                <div class="row small-3 columns">
                                    <span class="fa fa-music"></span>
                                </div>
                                @if(Session::get('OpID') == '15' || Session::get('OpID') == '3')
                                <div class="row small-9 columns"><p>كول تون</p></div>
                                @else
                                <div class="row small-9 columns"><p>أدعية الانتظار</p></div>
                                @endif
                            </a>
                        </li>



                        <!-- menu link 3 -->
                        <li class="video_li">
                            <a href='{{url(Session::get('OpID')."/all/video")}}' class="row">
                                <div class="row small-3 columns">
                                    <span class="fa fa-film"></span>
                                </div>
                                <div class="row small-9 columns"><p>فيديو</p></div>
                            </a>
                        </li>

                        <!-- menu link 4 -->
                        <li class="audio_li">
                            <a href='{{url(Session::get('OpID')."/all/audio")}}' class="row">
                                <div class="row small-3 columns">
                                    <span class="fa fa-headphones"></span>
                                </div>
                                <div class="row small-9 columns"><p>صوتيات</p></div>
                            </a>
                        </li>



                        <li class="greeting_li">
                            <a href='{{url(Session::get('OpID')."/all/greatings")}}' class="row">
                                <div class="row small-3 columns">
                                    <span class="fa fa-camera"></span>
                                </div>
                                <div class="row small-9 columns"><p>بطاقة التهنئة</p></div>

                            </a>
                        </li>


                <div class="parent">

                <li>
                 <a href='#' class="row">
                        <div class="row small-3 columns">
                            <span class="fa fa-chevron-down"></span>
                        </div>
                        <div class="row small-9 columns"><p>خدمات</p></div>

                    </a>
                   <ol class="child">
                   <li class="sebha_li"><a href="{{ url('/8/sebha')}}"> اختر التسبيح </a></li>
                   <li class="merath_li"><a href="{{ url('/8/merath')}}">حساب الميراث</a></li>
                   <li class="zakah_li"><a href="{{ url('/8/zakah')}}">حساب الزكاة</a></li>
                   </ol>
                 </li>

               </div>



                        <!-- official website -->
                        <!-- <li>
                            <a href='{{MISHARI_WEBSITE}}' class="row">
                                <div class="row small-3 columns">
                                    <span class="fa fa-globe"></span>
                                </div>
                                <div class="row small-9 columns"><p>الموقع الرسمي</p></div>
                            </a>
                        </li> -->


                        <li class="terms_li">
                            <a href='{{url(Session::get('OpID')."/terms")}}' class="row">
                                <div class="row small-3 columns">
                                    <span class="fa fa-info-circle"></span>
                                </div>
                                <div class="row small-9 columns"><p>الارشادات</p></div>
                            </a>
                        </li>


                        @if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active')
                        <li style="margin-bottom:10px;">
                            <a href='{{url(Session::get('OpID').'/logout')}}' class="row">
                                <div class="small-3 columns">
                                    <span class="fa fa-globe"></span>
                                </div>
                                <div class="small-9 columns"><p>خروج</p></div>
                            </a>
                        </li>
                        @else
                        <li style="margin-bottom:10px;">
                            <a href='{{url(Session::get('OpID').'/login2')}}' class="row">
                                <div class="small-3 columns">
                                    <span class="fa fa-globe"></span>
                                </div>
                                <div class="small-9 columns"><p>تسجيل الدخول</p></div>
                            </a>
                        </li>

                        @endif



                    </ul><!-- end menu categories -->
                </div>
                <div class="clear-bottom"></div>
                <!-- use socicon or icomoon fonts -->



                @if(Session::get('OpID') == '15' )
                <div class="social-media-wrapper">
                <div><!--<img class="ooredoo-logo-img ivas" src="{{ asset('img/WebApps/ooredoo/afasy/mobinil-logo.png') }}"/>--></div>
                </div>

                @else
                <div class="social-media-wrapper">
                    <div class="copyright">powered by </div>
                    <div><img class="ooredoo-logo-img ivas" src="{{ asset('img/WebApps/ooredoo/afasy/ivas_logo.png') }}"/></div>
                </div>
                @endif

                <!-- end social media wrapper -->

            </div><!-- end menu wrapper -->

        </div><!-- end menu-container -->


        <div class="site-wrapper">
            <header>
                <nav class="main-nav">
                    <div class="main-nav-wrapper">
                        <ul class="row status-toolbar">

                            <!-- if the visitor is not a subscriber -->
                            <!--<li class="flex-col-1"><a href='{{url("2/subscribe")}}'>اشترك</a></li>-->

                            <!-- if the visitor is  a subscriber -->
                            <li class="small-12 columns welcome">
                                @if(Session::has('MSISDN_ETISALAT'))
                                <p class="arabic-number">مرحبا {{session('MSISDN_ETISALAT')}}</p>

                                @endif


                                  @if(Session::has('success_validate'))
                                <div style="text-align: center;width: 100%;padding-top: 10px;color: green;">
                                   {{ Session::get('success_validate')}}
                                </div>

                                @endif

                            </li>

                            <!-- if the MSISDN can't be detected show login-->
                            <!--<li class="flex-col-1"><a href='{{url("2/login")}}'>تسجيل دخول</a></li>-->

                    <!--<li class="small-4 columns ooredoo-logo"><img class="ooredoo-logo-img" src="{{ asset('img/WebApps/ooredoo/afasy/ooredoo_logo.png') }}"/></li>-->

                            @yield('language')
                        </ul>

                        <ul class="menu-toolbar make-sticky cf">
                            <li class="burger-menu-btn"><span class="fa fa-bars"></span></li>

                            <!-- make this a partial -->
                            @yield('serviceLogo')


                            <!-- category page title and search -->
                            <!--<li class="flex-container row-center-vertical section-header">

                                <div class="flex-col-1 flex-container center-center">
                                    <span class="fa fa-music"></span>
                                </div>

                                <h2 class="flex-col-3 flex-container row-center-vertical"><span>All Rbts</span></h2>

                                <div class="flex-col-1 flex-container center-center search-btn">
                                    <span class="fa fa-search"></span>
                                </div>
                            </li>-->
                        </ul>
                    </div>
                </nav>

            </header>

            <section class="main-container">
<!--                 <div class="spinner">
                    <img src="{{asset('img/WebApps/ooredoo/afasy/ajax-loader.gif')}}"/>
                </div> -->

                <div style="display:none;" id="popup">
                    <!-- <audio controls autoplay>
                       <source src='http://misharialafasy.net/wap/etisalateg/media/Etisalat.mp3' type='audio/ogg'>
                     Your browser does not support the audio element.
                     </audio> -->
                </div>
@section('serviceLogo')
    <li class="service-logo hide-when-scroll cf">
        <div class="logo-text">
           <!-- <img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logotext_grey.svg')}}"/> -->
        </div>

        <div class="logo-img">
            <a href='{{url(Session::get('OpID'))}}'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')

        <!-- toggle Categories -->
        <ul class="toggle-menu row">
            <!-- the click event of the tab with class trigger-click will be triggered on page load -->
            <!-- tab 1 -->
          <li class="small-3 columns greeting">
                <a href='{{url(Session::get('OpID')."/latest/greeting")}}' class="toggle-btn">
                    <div>
                        <span class="fa fa-picture-o"></span>
                        <p>تهنئة</p>
                    </div>
                </a>
            </li>


            <!-- tab 2 -->
            <li class="small-3 columns video">
                <a href='{{url(Session::get('OpID')."/latest/video")}}' class="toggle-btn trigger-click">
                    <!--<span>Pictures</span>-->
                    <!-- icon and text -->
                    <div>
                        <span class="fa fa-film"></span>
                        <p>فيديو</p>
                    </div>
                </a>
            </li>

           <!-- tab 3 -->
           <li class="small-3 columns rbts">
                <a href='{{url(Session::get('OpID')."/latest/rbts")}}' class="toggle-btn">
                    <div flex-container center-center>
                        <span class="fa fa-music"></span>
                            @if(Session::get('OpID') == '15'  || Session::get('OpID') == '3')
                             <p>كول تون</p>
                            @else
                             <p>أدعية انتظار</p>
                            @endif

                    </div>
                </a>
            </li>




            <!-- tab 4 -->
            <li class="small-3 columns audio">
                <a href='{{url(Session::get('OpID')."/latest/audio")}}' class="toggle-btn">
                    <div>
                        <span class="fa fa-headphones"></span>
                        <p>صوتيات</p>
                    </div>
                </a>
            </li>


            <!-- tab 5 -->
           <li class="small-3 columns images">
                <a href='{{url(Session::get('OpID')."/latest/img")}}' class="toggle-btn">
                    <div>
                        <span class="fa fa-picture-o"></span>
                        <p>صور</p>
                    </div>
                </a>
            </li>


            <!-- tab 6 -->
            <li class="small-3 columns sebha">
                <a href='{{url(Session::get('OpID')."/sebha")}}' class="toggle-btn">
                    <div>
                        <span class="fa fa-cube"></span>
                        <p> اختر التسبيح    </p>
                    </div>
                </a>
            </li>





            <!-- tab 7 -->
            <li class="small-3 columns zakaah">
                <a href='{{url(Session::get('OpID')."/zakah")}}' class="toggle-btn">
                    <div>
                        <span class="fa fa-certificate"></span>
                        <p>الزكاة</p>
                    </div>
                </a>
            </li>


            <!-- tab 8 -->
           <li class="small-3 columns mrath">
                <a href='{{url(Session::get('OpID')."/merath")}}' class="toggle-btn">
                    <div>
                        <span class="fa fa-bed"></span>
                        <p>حساب الميراث</p>
                    </div>
                </a>
            </li>

        </ul>
        <!--<div class="timeline">

        </div>-->


                @yield('content')

            </section>
            <div class="clearfooter"></div>
            <footer>
                <div class="footer-wrapper">
                    <div class="social-media-wrapper">
                        <ul class="social-media cf">

                            <!-- social media 1 -->
                            <li>
                                <a href="https://www.facebook.com/Alafasy">
                                    <span class="fa fa-facebook"></span>
                                </a>
                            </li>

                            <!-- social media 2 -->
                            <li>
                                <a href="https://twitter.com/alafasy">
                                    <span class="fa fa-twitter"></span>
                                </a>
                            </li>

                            <!-- social media 1 -->
                            <li>
                                <a href="https://www.youtube.com/user/alafasychannels">
                                    <span class="fa fa-youtube"></span>
                                </a>
                            </li>

                            <!-- social media 1 -->
                            <li>
                                <a href="https://soundcloud.com/alafasy">
                                    <span class="fa fa-soundcloud"></span>
                                </a>
                            </li>

                            <!-- social media 2 -->
                            <li>
                                <a href="https://instagram.com/mishari_alafasy">
                                    <span class="fa fa-instagram"></span>
                                </a>
                            </li>

                            <li>
                                <a href="{{MISHARI_WEBSITE}}">
                                    <span class="fa fa-globe"></span>
                                </a>
                            </li>


                        </ul><!-- end social media-->
                    </div>
                </div>
        </div>
    </div>
</footer>
</div><!-- end site wrapper -->

<div style="display:none;" id="popup">
    <!-- <audio controls autoplay>
       <source src='http://misharialafasy.net/wap/etisalateg/media/Etisalat.mp3' type='audio/ogg'>
     Your browser does not support the audio element.
     </audio> -->
</div>



<!-- My scripts -->
<script src="{{ asset('js/WebApps/ooredoo/main_etisalateg.js') }}"></script>
<script src="{{asset('js/vendor/video-js/video.js')}}"></script>
<script src="{{asset('js/WebApps/ooredoo/slick/slick.min.js')}}"></script>
@yield('script')
<script>

if (localStorage.getItem('popState') != 'shown') {
    $("#popup").delay(2000).fadeIn();
    $("<audio controls autoplay><source src='http://misharialafasy.net/wap/etisalateg/media/Etisalat.mp3' type='audio/ogg'>Your browser does not support the audio element.</audio>").appendTo("#popup");
    localStorage.setItem('popState', 'shown')
}

$('#popup-close').click(function (e) // You are clicking the close button
{
    $('#popup').fadeOut(); // Now the pop up is hiden.
    $('#popup source').attr("src", ' ');
});
$('#popup').click(function (e)
{
    $('#popup').fadeOut();
    $('#popup source').attr("src", ' ');
});



// $('.js-modal-show').click(function(){
//   $('.js-modal-shopify').toggleClass('is-shown--off-flow').toggleClass('is-hidden--off-flow');
// });

$('.js-modal-hide').click(function () {
    $('.js-modal-shopify').toggleClass('is-shown--off-flow').toggleClass('is-hidden--off-flow');
});

</script>
<script>

    function myFunction() {
        $('#first_modal').addClass('fade_modal');
    }
    // click on close btn in first modal مواقيت الصلاة  >> hide modal
    $('#first_modal .header-close').click(function(){
        $('#first_modal').removeClass('fade_modal');
    });


    // click on close btn in second modal اقرب مسجد >> hide modal
    // click on link  مواقيت الصلاة which in second modal >> show the first modal
    $('#second_modal .header-close , #second_modal .footer-link').click(function(){
        $('#second_modal').removeClass('fade_modal');
    });


    // click on link اقرب مسجد which in first modal >> show the second modal
    $('#first_modal .footer-link').click(function(){
        $('#second_modal').addClass('fade_modal');
    });


</script>


<?php
/*
  if (isset($_COOKIE['audioPlay'])) {

  }else{

  setcookie("audioPlay", 1, time()+3600);

  echo "<audio controls autoplay>
  <source src='http://misharialafasy.net/wap/etisalateg/media/Etisalat.mp3' type='audio/ogg'>
  <source src='http://misharialafasy.net/wap/etisalateg/media/Etisalat.mp3' type='audio/mpeg'>
  Your browser does not support the audio element.
  </audio>";

  }
 */
?>
 <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
</body>
</html>
