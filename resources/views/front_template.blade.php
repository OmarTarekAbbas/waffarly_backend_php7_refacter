<!DOCTYPE html>
<html lang="en-US">


<head>

    <!-- Facebook Pixel Code -->
    <script>
    ! function(f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function() {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '261541571464137');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=261541571464137&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126101657-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-126101657-1');
    </script>


    <title>خدمة وفرلي - برعاية ايفاز</title>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="x-ua-compatible">
    <meta content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" name="viewport">
    <link href="https://fonts.googleapis.com/css?family=Lateef" rel="stylesheet">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="yes" name="apple-touch-fullscreen">
    <link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.css')}}">
    @if (request()->get('OpID') == Etisalat_Bundle_Route)
    <link rel="stylesheet" type="text/css" href="{{url('css/home.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{url('css/home.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('css/du_home.css')}}">
    @endif




<style>
.active{
    color: red
}
</style>



    <link rel="stylesheet" type="text/css" href="{{url('css/responsive.css')}}">
    <link rel="icon" href="{{url('images/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{url('images/favicon.ico')}}">


    <?php

    // $digest = "GCLOGWWB3FgsDKA11Dwc:d08a80a061790f9bf73d7f38444b16cc174810cc6c7d2f277eec71dbf6f00e60" ;
    $date=gmdate("Y-m-d H:i:s\Z");
    $lang="ar";
    $theme="light";
    $publicKey="GCLOGWWB3FgsDKA11Dwc";
    $privateKey="YSSd8msGWd0XTpZ94KZN";
    $message =$date.$lang.$theme;
    $digest=$publicKey.":".hash_hmac("sha256",$message ,$privateKey);
    $js ="http://lookup.tpay.me/idxml.ashx/js-staging?date=".$date."&lang=".$lang."&theme=".$theme."&digest=".$digest;

    ?>

    <script src="<?php echo $js;?>"></script>

    <script>
    msisdn = "";
    operatorCode = "";

    function TPay_functions() {

        $("#new_subscriber").css("display", "none");

        try {
            TPay.HeaderEnrichment.confirm(60604, "yallawaffar", "yallawaffar",
                function(result, refNo) { // still refNo user is rejected
                    if (result == true) {
                        var signature = null;
                        var session_id = TPay.HeaderEnrichment.sessionId();
                        msisdn = TPay.HeaderEnrichment.msisdn();
                        operatorCode = TPay.HeaderEnrichment.operatorCode();

                        /*
                        alert( "popup is clicked") ;
                        alert( "session id : "+ TPay.HeaderEnrichment.sessionId()) ;     // integer
                        alert( "operator code : " +  TPay.HeaderEnrichment.operatorCode()) ;   // 60201
                        alert( "Msisdn : " +  TPay.HeaderEnrichment.msisdn()) ;
                        *


                        //  var client_date = {"msisdn":msisdn,"operatorCode":operatorCode} ;

                        TPay_functions2();

                        /*
                         $.ajax({
                         method:"POST",
                         url: "{{url('tpay_subscribe_json')}}",
                         data: client_date ,
                         success: function(result){
                         alert(result)
                         }
                         });
                         */

                    } else {
                        // alert("error is:" + refNo);
                        alert("يوجد خطأ");
                    }

                });
            //var session_id = TPay.HeaderEnrichment.sessionId() ;


        } catch (e) {
            // alert(e.message);
            alert("يوجد خطأ");
        }

    }







    function TPay_functions2() {
        /*
        alert( "operator code2222: " +  operatorCode) ;
        alert( "Msisdn 2222: " + msisdn) ;
        */
        $.ajax({
            method: "POST",
            url: "{{url('tpay_subscribe_json')}}",
            data: {
                "msisdn": msisdn,
                "operatorCode": operatorCode
            },

            success: function(result) {
                alert(result);

                data = JSON.parse(result);
                alert(data);
                alert(data.val);
                if (data.val == 1 || data.val == 2 || data.val == 3) {
                    alert(data.message);
                } else if (data.val == 4) {
                    alert("success");
                    window.location.href = "{{url('/confirm')}}";
                } else {
                    // alert("fail unknow error");
                    alert("يوجد خطأ");
                }
            },
            error: function() {
                //  alert("ajax error");
                alert("يوجد خطأ");
            }
        });

    }
    </script>







</head>

<body>





@yield('popup_HE')


<div class="loader-app">
    <!--<h3>وفرلى</h3>-->
        <img src="{{url('images/logo.png')}}" alt="وفرلى">
    <div class="ld ld-ring ld-spin-fast huge"></div>
</div>
<div id="main">
    <div id="slide-out-right" class="side-nav">
        <ul class="collapsible" data-collapsible="accordion">

        <!-- @if(Session::has('phone_number'))
            <span class="phone_subscriber">{{ Session::get('phone_number') }}</span>
                @endif -->

                <li><a href="{{url('/')}}" class="link_href"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
                @if(Session::has('MSISDN_ETISALAT'))
                    <li class=""><a href="#0" class="link_href"><i class="fa fa-user"></i>{{session('MSISDN_ETISALAT')}}</a></li>
                @endif
            <li>
                <a class="collapsible-header"><i class="fa fa-shopping-bag"></i> التصنيفات <span
                        class="angle-left fa fa-angle-left"></span></a>
                <div class="collapsible-body submenu" style="display: none">
                    <ul>
                                @foreach(categories() as $category)
                                    <li><a
                                            href="{{route('category' , ['id' => $category->id])}}" class="link_href">{{$category->title}}</a>
                                    </li>
                                @endforeach
                    </ul>
                </div>
            </li>
            <li>
                <a class="collapsible-header"><i class="fa fa-shopping-bag"></i> العلامات التجارية <span
                        class="angle-left fa fa-angle-left"></span></a>
                <div class="collapsible-body submenu" style="display: none">
                    <ul>
                        @foreach(brands() as $val)
                            <li class="brand-item separator-right separator-bottom">
                                <div class="brand-title">
                                    <a href="{{route('brand' , ['id' => $val->id])}}" class="brand-title_reduced link_href">{{$val->brand_name}}</a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li>
                <div class="line-separator"></div>
            </li>
            <li><a href="{{route('terms')}}" class="link_href"><i class="fa fa-edit"></i> الارشادات</a></li>
                @if (request()->get('OpID') == Etisalat_Bundle_Route)
                    @if (Session::has('MSISDN_ETISALAT') && Session::get('Status') == 'active')
                    <li><a href="{{url('logout_web')}}" class="link_href"><i class="fa fa-sign-out"></i> خروج</a></li>
                    @else
                    <li><a href="{{url(Etisalat_Bundle_Route .'/login_web')}}" class="link_href"><i
                                class="fa fa-sign-in"></i> دخول</a></li>
                    @endif
                @endif
        </ul>
    </div>

    @yield('front_content')

    <div class="footer">
        <div class="copyright">Copyright © {{\Carbon\Carbon::now()->year}} – iVAS</div>
    </div>
    <div id="to-top" class="main-bg"><i class="fa fa-chevron-up"></i></div>


</div>


@yield('script')
<script type="text/javascript" src="{{url('js/jquery.js')}}"></script>
<script>
    $(window).on('load', function() {

        $('.over').addClass('activeSub');

    });
    $('#x_icon').on('click', function() {
        $('.over').hide();
    });
</script>


@yield('check_HE')

@yield('remove_susbcribe_fancy')


<script type="text/javascript" src="{{url('js/materialize.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/jquery.mixitup.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/jquery.swipebox.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/custom.js')}}"></script>
@yield('script2')
<script>
    /* Start Active Menu */
    $(function() {
        // this will get the full URL at the address bar
        var url = window.location.href;
        $(" ul li a").each(function() {
            // checks if its the same on the address bar
            if (url == (this.href)) {
                $(this).closest("li ").addClass("current-item");
                $(this).closest("a").addClass("active");
                $(this).closest(".submenu").css("display", "block");

            }

        });
    });
</script>

<script>
   op_id = {{ isset($_REQUEST['OpID']) ? 1 : 0 }}
   if (op_id) {
     var operator_id = {{ isset($_REQUEST['OpID']) ? $_REQUEST['OpID'] : '' }}
     $('.link_href').each(function() {
       console.log($(this));
       var $this = $(this);
       var _href = $this.attr("href");
          if (_href.includes('?')) {
            $this.attr("href", _href + '&OpID=' + operator_id);
          } else {
            $this.attr("href", _href + '?OpID=' + operator_id);
          }
        });
      }

</script>

</body>


</html>
