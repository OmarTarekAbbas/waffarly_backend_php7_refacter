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
                                    @if($item->operator_id==null)
                                        <a class="thumbnail" href="{{url('get_product?product_id='.$item->product_id)}}"><img src="{{url($item->product_image)}}" class="img-circle"  alt=""></a>
                                    @else
                                        <a class="thumbnail" href="{{url('get_product?product_id='.$item->id."&operator_id=".$item->operator_id)}}"><img src="{{url($item->product_image)}}" class="img-circle"  alt=""></a>
                                    @endif
                                    <div class="overlay"></div>
                                    <div class="caption">
                                        <div class="rating">
                                            @if($item->operator_id==null)
                                                <a href="{{url('get_product?product_id='.$item->product_id)}}">{{$item->title}}</a>/
                                                <a href="{{url('get_category?category_id='.$item->category_id)}}">{{$item->category_name}}</a>/
                                                <a href="{{url('get_brand?brand_id='.$item->brand_id)}}">{{$item->brand_name}}</a>
                                                 </div>
                                            @else
                                                <a href="{{url('get_product?product_id='.$item->id."&operator_id=".$item->operator_id)}}">{{$item->title}}</a>/
                                                <a href="{{url('get_category?category_id='.$item->category_id."&operator_id=".$item->operator_id)}}">{{$item->category_name}}</a>/
                                                <a href="{{url('get_brand?brand_id='.$item->brand_id."&operator_id=".$item->operator_id)}}">{{$item->brand_name}}</a></div>
                                            @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                <?php
                $categories = Helper::standards($request) ;
                   // print_r($categories); die;

                ?>
                    @foreach($categories as $category)
                        <div class="category_products">
                            <h1 class="page-title margin-bottom animated fadeIn">{{$category->category_name}}</h1>
                            <div class="maleo-card animated fadeInUp">
                                <ol class="product-list">
                                    @foreach($products as $index=>$product)
                                        @if($category->id==$product->category_id)
                                            <li class="product-item separator-right separator-bottom">
                                            @if($product->operator_id!=null)
                                                <a class="thumb" href="{{url('get_product?product_id='.$product->id."&operator_id=".$product->operator_id)}}"><img src="{{url($product->product_image)}}" class="img-circle" alt=""></a>
                                                <div class="product-price"><a href="{{url('get_brand?brand_id='.$product->brand_id."&operator_id=".$product->operator_id)}}" class="product-price_reduced">{{$product->brand_name}}</a>
                                                / <a href="{{url('get_product?product_id='.$product->id."&operator_id=".$product->operator_id)}}" class="product-price_reduced">{{$product->title}}</a>
                                                </div>
                                            @else
                                                <a class="thumb" href="{{url('get_product?product_id='.$product->id)}}"><img src="{{url($product->product_image)}}" class="img-circle" alt=""></a>
                                                <div class="product-price"><a href="{{url('get_brand?brand_id='.$product->brand_id)}}" class="product-price_reduced">{{$product->brand_name}}</a> /
                                                <a href="{{url('get_product?product_id='.$product->id)}}" class="product-price_reduced">{{$product->title}}</a></div>
                                            @endif
                                        @endif
                                        </li>
                                    @endforeach
                                   <!--  ====== more ====== -->
                                    <div class="col-xs-12 main_more">
                                         @if($product->operator_id!=null)
                                          <a href="{{url('get_category?category_id='.$category->id."&operator_id=".$product->operator_id)}}"> المزيد</a>
                                         @else
                                          <a href="{{url('get_category?category_id='.$category->id)}}"> المزيد</a>
                                         @endif

                                    </div>
                                    <!--  ====== more ====== -->
                                    <div class="clear"></div>
                                </ol>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
                <!-- //HERE IS CONTENTS -->
@stop
