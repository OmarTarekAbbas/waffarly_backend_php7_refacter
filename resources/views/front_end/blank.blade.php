@extends('front_template')
@section('front_content')
        <div id="page">
            <div class="top-navbar">
                <div class="top-navbar-right"><a href="#" id="menu-right" data-activates="slide-out-right"><i class="fa fa-bars"></i></a></div>
                <div class="top-navbar-left back_btn"><a data-activates="slide-out-right"><i class="fa fa-caret-left"></i></a></div>
                <div class="top-navbar-left"><a href="search.blade.php" data-activates="slide-out-right"><i class="fa fa-search"></i></a></div>
                <div class="site-title" *ngIf="logo">
                    <!--<h1>وفرلى</h1>-->
                    <img src="images/logo.png" alt="وفرلى">
                </div>
            </div>
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                
                <!-- //HERE IS CONTENTS -->
            </div>
            <div class="footer">
                <div class="social-footer">
                    <a href="#" class="facebook"><i class="fa fa-facebook"></i></a>
                    <a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
                </div>
                <div class="copyright">Copyright © 2017 – iVAS</div>
            </div>
            <div id="to-top" class="main-bg"><i class="fa fa-chevron-up"></i></div>
        </div>
@stop
