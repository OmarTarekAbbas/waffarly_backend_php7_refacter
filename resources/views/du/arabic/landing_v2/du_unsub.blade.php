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

    <link rel="stylesheet" type="text/css" href="{{url('css/responsive.css')}}">
    <link rel="icon" href="{{url('images/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{url('images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{url('front/landing.css')}}">

</head>

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
                <h5 class="text-center h3">@lang('messages.du_unsub')
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
                            <a href="#" class="close" data-dismiss="alert" aria-label="close" onclick="this.parentElement.style.display='none';">&times;</a>
                            {{ Session::get('success')}}
                        </div>
                        @elseif(Session::has('failed'))
                        <div class="alert alert-danger alert-dismissible">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        {{ Session::get('failed')}}
                        </div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="container">
                <div class="form_content">
                    <form method="post" action="{{url('du_unsubcr')}}"    onsubmit="document.getElementById('zain_submit').disabled='true';"  id="form_zain">
                        {{ csrf_field() }}
                        <div class="form-group form-inline">
                            <input type="hidden" name="peroid" value="{{$peroid}}">
                            <input type="hidden" name="lang" value="{{$lang}}">
                            <label for="phone"><span>971</span></label>
                            <input type="tel" class="form-control" id="phone" required=""
                                placeholder="@lang('messages.du_enter_mob')" name="number" required pattern="[0-9]{9}">
                            <i class="fa fa-times text-danger" style="display: none!important"></i>
                        </div>
                        <button id="zain_submit" class="btn" type="submit">@lang('messages.du_unsub')</button>
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
