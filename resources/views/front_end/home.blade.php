@extends('front_template')
@section('front_content')

<div id="page">
    @extends('top_navbar')
    <div class="content-container">
        <!-- HERE IS CONTENTS -->
        <div class="pages home-page">
            <div class="maleo-card margin-bottom animated fadeInRight">
                <div class="featured-slider">
                    @foreach($featured as $item)
                    <div class="featured-item">
                        <a class="thumbnail link_href" href="{{route('product' , ['id' => $item->id])}}"><img src="{{url('uploads/'.$item->product_image)}}" class="img-circle" alt=""></a>

                        <div class="overlay"></div>
                        <div class="caption">
                            <div class="rating">
                            <a href="{{route('product' , ['id' => $item->id])}}" class="link_href">{{$item->title}}</a>/
                                <a href="{{route('category' , ['id' => $item->category_id])}}" class="link_href">{{$item->category_name}}</a>/
                                <a href="{{route('brand' , ['id' => $item->brand_id])}}" class="link_href">{{$item->brand_name}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- brands -->
            <div class="brand-products">
                <h1 class="page-title margin-bottom animated fadeIn">العلامات التجارية</h1>
                <span class="title-line">ـــــــــــــــــــــــــــــــ</span>
                <div class="maleo-card animated fadeInUp">
                    <div class="maleo-card animated fadeInUp">
                        <ol class="brand-list">
                            @foreach($brands as $val)
                            <li class="brand-item separator-right separator-bottom">
                                <a class="thumb link_href" href="{{route('brand' , ['id' => $val->id])}}">
                                    <img src="{{url('uploads/'.$val->image)}}" class="img-circle" alt="">
                                </a>
                                <div class="brand-title">
                                    <a href="{{route('brand' , ['id' => $val->id])}}" class="brand-title_reduced link_href">{{$val->brand_name}}</a>
                                </div>
                            </li>
                            @endforeach
                            <div class="clear"></div>
                        </ol>
                    </div>
                </div>
                <!-- end brands -->
                <div class="category_products">
                    <h1 class="page-title margin-bottom animated fadeIn">التصنيفات</h1>
                    <span class="title-line">ـــــــــــــــــــــــــــــــ</span>
                    <div class="maleo-card animated fadeInUp">
                        <div class="row">
                            <ol class="product-list">
                                @foreach($categories as $category)
                                <li class="product-item separator-right separator-bottom">
                                    <div class="col-xs-6">
                                        <a class="thumb link_href" href="{{route('category' , ['id' => $category->id])}}"><img src="{{$category->image}}" class="img-circle" alt=""></a>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="product-price"><a href="{{route('category' , ['id' => $category->id])}}" class="product-price_reduced link_href">{{$category->title}}</a>
                                        </div>
                                    </div>
                                </li>
                                <div class="clear"></div>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <!-- //HERE IS CONTENTS -->

    @stop
