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
                        <a class="thumbnail" href="{{url('get_product?product_id='.$item->product_id)}}"><img src="{{url('uploads/'.$item->product_image)}}" class="img-circle" alt=""></a>

                        <div class="overlay"></div>
                        <div class="caption">
                            <div class="rating">
                            <a href="{{url('get_product?product_id='.$item->product_id)}}">{{$item->title}}</a>/
                                <a href="{{url('get_category?category_id='.$item->category_id)}}">{{$item->category_name}}</a>/
                                <a href="{{url('get_brand?brand_id='.$item->brand_id)}}">{{$item->brand_name}}</a>
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
                                <a class="thumb" href="{{'get_brand?brand_id='.$val->id}}">
                                    <img src="{{url('uploads/'.$val->image)}}" class="img-circle" alt="">
                                </a>
                                <div class="brand-title">
                                    <a href="{{'get_brand?brand_id='.$val->id}}" class="brand-title_reduced">{{$val->brand_name}}</a>
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
                                        <a class="thumb" href="{{url('get_category?category_id='.$category->id)}}"><img src="{{url('uploads/'.$category->image)}}" class="img-circle" alt=""></a>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="product-price"><a href="{{url('get_category?category_id='.$category->id)}}" class="product-price_reduced">{{$category->category_name}}</a>
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
