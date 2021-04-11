<!DOCTYPE html>
<html lang="en" style="height:100%;">

<head>
  <meta charset="utf-8">
  <!--IE Compatibility Meta-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--Mobile Meta-->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Du Snap Landing Page</title>
  <link rel="stylesheet" type="text/css" href="{{ url('assets/front/landing_v2')}}/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/front/landing_v2')}}/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/front/landing_v2')}}/css/main-style_zain.css">
  <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
</head>

<style type="text/css">
  .landing_page .strip {
    margin-top: 0;
  }
</style>

<body>
  <div class="main_container">
    <div class="landing_page">

      <div class="start_video" id="video">
        <!-- <video width="100%" autoplay muted loop="true">
                    <source src="{{ url('assets/front/landing_v2')}}/video/1.mp4" type="video/mp4">
                </video> -->
        <img width="100%" src="{{ url('assets/front/landing_v2')}}/img/01.jpg" alt="فلاتر">
      </div>

      <div class="strip">
        <h2>استمتع بوقتك مع فلاتر</h2>
      </div>

      <div class="shbka">
        <div class="container">
          <h3 class="h4 my-4 text-success bg-white rounded font-weight-normal">تم اشتراكك بنجاج في خدمة فلاتر</h3>
          <div class="zain_viva">
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ Session::get('success')}}
            </div>
            @elseif(Session::has('failed'))
            <div class="alert alert-danger alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              {{ Session::get('failed')}}
            </div>
            @endif
            <div class="row justify-content-center">
              <!--<div class="col-12">
                                <img src="img/viva.png" id="viva">
                            </div>-->

              <div class="col-12">
                {{-- <img src="{{ url('assets/front/landing_v2')}}/img/mobily.png" id="zain"> --}}
                <img src="{{ url('assets/front/landing_v2')}}/img/DuLogo.png" id="zain">
              </div>

              <!--<div class="col-12">
                                <img src="img/oredoo.png" id="ooredoo">
                            </div>-->
            </div>
          </div>
        </div>
      </div>

      {{-- <div class="cancel">
                <p>لالغاء الاشتراك يرجي الضغط علي هذا <a href="{{url('du_unsub')}}">الرابط</a></p>
    </div> --}}


  </div>

  <!-- copyright -->
  <!-- {{-- <div class="copy">
    <p>copyright @ <span><?php echo date("Y") ?></span> DigiZone, all rights reserved.</p>
  </div> --}} -->
  <!-- copyright -->

  <!-- loading -->
  <div class="loading-overlay">
    <div class="spinner">
      <img src="{{ url('assets/front/landing_v2')}}/img/logo.jpg" alt="loading_snap">
    </div>
  </div>
  <!-- end loading -->
  </div>
  <!-- script -->
  <script src="{{ url('assets/front/landing_v2')}}/js/jquery-3.3.1.min.js"></script>
  <script src="{{ url('assets/front/landing_v2')}}/js/popper.min.js"></script>
  <script src="{{ url('assets/front/landing_v2')}}/js/bootstrap.min.js"></script>
  <script src="{{ url('assets/front/landing_v2')}}/js/script_zain.js"></script>

</body>

</html>