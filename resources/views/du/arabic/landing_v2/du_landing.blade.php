<!DOCTYPE html>
<html lang="en-US">

<head>
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

    @if ( Route::getCurrentRoute()->getActionName() == "App\Http\Controllers\FrontEndController@index"){
    <link rel="stylesheet" type="text/css" href="{{url('css/home.css')}}">
    @else
    <link rel="stylesheet" type="text/css" href="{{url('css/style_two_grid.css')}}">
    @endif
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{url('css/responsive.css')}}">
    <link rel="icon" href="{{url('images/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{url('images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{url('front/landing.css')}}">

</head>
<style>
    .landing_page .form_content {
        position: absolute;
    }
</style>

<body>

    @php
    App::setLocale($lang);
    @endphp
    <?php
if ($lang == 'ar') {
    $text = "text-align: right";
    $float = "float: right;";
} else {
    $text = "text-align: left";
    $float = "float: left;";
}
?>

    <div class="main_container">
        <div class="landing_page">
            <div class="text-offer" style="margin-top: 15%;color:white">
                <h5 class="text-center h3">@lang('messages.du_enjoy') @if ($lang == 'ar' && $peroid == 'daily')
                    {{'اليومية'}} @elseif($lang == 'ar' && $peroid == 'weekly') {{'الاسبوعية'}} @else {{$peroid}} @endif
                </h5>
            </div>
            <div class="shbka">
                <div class="container">
                    <div class="oredoo">
                        <div class="row justify-content-center">

                            <div class="col-xs-12">
                                <div>
                                </div>
                                <img src="{{asset('images')}}/logo.png" id="du_ landing"
                                    style="width: 73%;margin-right: 38px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shbka">
                <div class="container">

                    <div class="zain_viva">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" onclick="this.parentElement.style.display='none';" aria-label="close">&times;</a>
                            {{ Session::get('success')}}
                        </div>
                        @elseif(Session::has('failed'))
                        <div class="alert alert-danger alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" onclick="this.parentElement.style.display='none';" aria-label="close">&times;</a>
                            {{ Session::get('failed')}}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form_content">
                    <form method="get" action="{{url('/DuSecureRedirect')}}"   onsubmit="document.getElementById('zain_submit').disabled='true';"  id="form_zain">
                        {{ csrf_field() }}
                        <ul class="text-danger   rounded ml-3"
                            style="width: 100%;font-weight:900;list-style-type: none;{{$text}}">
                            <li id="numeric" style="display: none;">@lang('messages.du_valid_num') <i
                                    class="fa fa-dot-circle" style="{{$float}}"></i></li>
                            <li id="numericnum" style="display: none;">@lang('messages.du_valid_num9') <i
                                    class="fa fa-dot-circle" style="{{$float}}"></i></li>
                        </ul>
                        <div class="form-group form-inline">
                            <label for="phone"><span>+ 971</span></label>
                            <input type="hidden" name="peroid" value="{{$peroid}}">
                            <input type="hidden" name="lang" value="{{$lang}}">
                            <input type="number" class="form-control" id="phone" value=""
                                placeholder="@lang('messages.du_enter_mob')" name="number" required pattern="[0-9]{9}">
                            <i class="fa fa-times text-danger" style="display: none!important"></i>
                        </div>
                        <!--<button class="btn back">رجوع</button>-->
                        <button id="zain_submit" class="btn" type="submit">@lang('messages.subscribe')</button>
                        <a href="{{url('du_unsubc/'.$peroid.'/'.$lang)}}" class="unsub"
                            style="color:#8C181A">@lang('messages.du_unsub2')</a>
                    </form>
                </div>
            </div>
        </div>

        <div id="to-top" class="main-bg"><i class="fa fa-chevron-up"></i></div>
    </div>
    </div>
</body>
<script type="text/javascript" src="{{url('js/jquery.js')}}"></script>
<script type="text/javascript" src="{{url('front/landing.js')}}"></script>


</html>
