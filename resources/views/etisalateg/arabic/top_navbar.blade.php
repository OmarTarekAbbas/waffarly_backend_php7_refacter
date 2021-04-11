<div class="top-navbar">
    <div class="top-navbar-left"><a href="#" id="menu-right" data-activates="slide-out-right"><i class="fa fa-bars"></i></a></div>
    <div class="top-navbar-right back_btn"><a data-activates="slide-out-right"><i class="fa fa-caret-left"></i></a></div>
        <div class="top-navbar-right"><a href="{{url(Etisalat_Bundle_Route.'/search')}}" data-activates="slide-out-right"><i class="fa fa-search"></i></a></div>
    <div class="site-title" >

       <?php
        $settings = Helper::init()[1] ;
        ?>
        @if($settings!=null && file_exists($settings[1]->value))
               <a href="{{url(Etisalat_Bundle_Route)}}">
                   <img src="{{url($settings[1]->value)}}" alt="وفرلى">
               </a>
        @else
               <a href="{{url(Etisalat_Bundle_Route)}}">
                   <img src="{{url('images/logo.png')}}" alt="وفرلى">
               </a>

        @endif
    </div>
</div>
