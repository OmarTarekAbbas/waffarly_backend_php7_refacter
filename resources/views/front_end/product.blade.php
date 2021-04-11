@extends('front_template')
@section('front_content')
        <div id="page">
            @extends('top_navbar')
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                @if(isset($product) && $product!=null)
                <div class="pages product-page">
                    <div class="maleo-card product-single animated fadeInUp">
                    <div class="product-price"><h3>{{$product->title}}</h3></div>
                        <div class="thumb"><img src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></div>
                        <!-- Product header contain product name, price & rating-->
                        <div class="product-header">
                        <div class="product-price"><a href="{{route('brand' , ['id' => $product->brand_id])}}" class="product-price_reduced">{{$product->brand_name}}</a></div>
                                <div class="product-price"><a href="{{route('category' , ['id' => $product->category_id])}}" class="product-price_reduced">{{$product->category_name}}</a></div>
                        </div>
                    </div>
                </div>
                @else
                <h1 style="text-align: center; margin-top: 10%;">لا يوجد منتج</h1>
                @endif
                <!-- //HERE IS CONTENTS -->
            </div>
        </div>
@stop
@section('script2')

@stop
