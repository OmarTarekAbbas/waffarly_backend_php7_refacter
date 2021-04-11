@extends('etisalateg.arabic.master')

<?php
$baseUrl = Session::get('OpID');
$englishUrl = Session::get('OpID');
?>
@section('title')
    <title>وفرلي|الرئيسية</title>
@stop
@section('serviceLogo')
    <li class="service-logo hide-when-scroll cf">
        <div class="logo-text">
         <!--   <img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logotext_grey.svg')}}"/> -->
        </div>

        <div class="logo-img">
            <a href='{{url(Session::get('OpID'))}}'><img src="{{asset('etisalateg/img/WebApps/ooredoo/afasy/logo.png')}}"/></a>
        </div>
    </li>
@stop
@section('content')
                <div class="spinner">
                    <img src="{{asset('img/WebApps/ooredoo/afasy/ajax-loader.gif')}}"/>
                </div>
<style>
    .videoSlider .thumbnail {
        height: 180px !important;
    }
    .videoSlider .slick-list {
        height: 180px;
    }
    .videoSlider .slick-prev:before, .slick-next:before,
    .videoSlider .slick-dots li button:before {
        color: #6ea31b;
    }
    .toggle-result {
        overflow-x: initial;
    }
    .more {
        margin: 60px auto;
    }

</style>
    <section class="home main-container-wrapper">
        <!-- toggle Categories -->
        <!--<div class="timeline">

        </div>-->
        <section class="toggle-result">
        <div id="all-media">
            @if(count($latestVideo) == 0 )
                <p class="no-recent">لا يوجد جديد</p>
            @else
                <!-- video gallery thumbs -->
                <ul class="media-gallery video videoSlider">

                    <!--
                    <li>
                       <a href='/' class="thumbnail" data-video-title="video 1">
                           <div class="media-wrapper">
                                <img src="http://ivas.com.eg/cms/Contents/Al Afasy/thumb/24-04-2017/1493050128.jpg">
                               <h3 class="media-title">عنوان الفيديو</h3>

                           </div>
                       </a>
                    </li>

                    <li>
                       <a href='/' class="thumbnail" data-video-title="video 1">
                           <div class="media-wrapper">
                                <img src="http://ivas.com.eg/cms/Contents/Al Afasy/thumb/24-04-2017/1493050128.jpg">
                               <h3 class="media-title">عنوان الفيديو</h3>

                           </div>
                       </a>
                    </li>

                    <li>
                       <a href='/' class="thumbnail" data-video-title="video 1">
                           <div class="media-wrapper">
                                <img src="http://ivas.com.eg/cms/Contents/Al Afasy/thumb/24-04-2017/1493050128.jpg">
                               <h3 class="media-title">عنوان الفيديو</h3>

                           </div>
                       </a>
                    </li>

                    <li>
                       <a href='/' class="thumbnail" data-video-title="video 1">
                           <div class="media-wrapper">
                                <img src="http://ivas.com.eg/cms/Contents/Al Afasy/thumb/24-04-2017/1493050128.jpg">
                               <h3 class="media-title">عنوان الفيديو</h3>

                           </div>
                       </a>
                    </li>
                    -->


                    @foreach($latestVideo as $video)
                    <li>
                       <a href='{{url("$baseUrl/landing/$video->PID")}}' class="thumbnail" data-video-title="video 1">
                           <div class="media-wrapper">
                                <img src="{{CRM_URL}}/cms/{{$video->content->thumb}}">
                               <h3 class="media-title">{{$video->Title}}</h3>

                           </div><!-- end video wrapper -->
                       </a> <!-- video -->
                    </li>
                    @endforeach
                </ul>
            @endif

            <a href='{{url("$baseUrl/all/video")}}' class="xs-toggle-btn more">المزيد</a>
@if(count($latestRBTs) == 0 )
        <p class="no-recent">لا يوجد جديد</p>
    @else
    <ul class="audio-play-list" id="all-media">
        @foreach($latestRBTs as $rbt)
        <li class="search-hook">
            <a href='{{url("$baseUrl/landing/rbt/$rbt->id")}}' class="cf arabic">
                <div class="play-status flex-container center-center"><span class="fa fa-play"></span></div>
                <p class="flex-col-3">{{$rbt->title}}</p>
            </a>
        </li>
        @endforeach
    </ul>
    @endif


        </div>
        </section>
    </section>
         <script type="text/javascript">
          $('.video a').addClass('active');
          $('.video_li').addClass('active_li');
     </script>
@stop
