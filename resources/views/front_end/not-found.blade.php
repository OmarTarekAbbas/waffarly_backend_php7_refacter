@extends('front_template')
@section('front_content')
    <style>
        .not-found h2{
            font-size: 50px;
            font-weight: 700;
            margin: 0;
            padding: 24px;
            color: #ccc;
        }
    </style>
        <div id="page">
            @extends('top_navbar')
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                <div class="pages not-found-page">
                    <div class="not-found animated fadeIn">
                        <h2>لا يوجد منتجات.</h2>
                        <div class="btn-to-home"><a href="{{url('/')}}" class="btn"><i class="fa fa-home"></i> الرجوع للرئيسية</a></div>
                    </div>
                </div>
                <!-- //HERE IS CONTENTS -->
            </div>


        </div>

@stop
