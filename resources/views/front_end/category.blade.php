@extends('front_template')
@section('front_content')
<div id="page">
    @extends('top_navbar')
    <div class="content-container">
        <!-- HERE IS CONTENTS -->
        <div class="pages brand-page">
            @foreach($products as $index=>$product)
            @if($index==0)
            <h1 class="page-title margin-bottom animated fadeIn">{{$product->category_name}}</h1>
            @endif
            <div class="categories-list">
                <div class="maleo-card maleo-blog_small margin-bottom_low animated">
                    @if($product->operator_id==null)
                    <h3 class="productName"><a href="{{url('get_product?product_id='.$product->product_id)}}">{{$product->prod_title}}</a></h3>
                    <a class="maleo-blog_thumb" href="{{url('get_product?product_id='.$product->product_id)}}"><img src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
                    @else
                    <h3 class="productName"><a href="{{url('get_product?product_id='.$product->product_id.'&operator_id='.$product->operator_id)}}">{{$product->prod_title}}</a></h3>
                    <a class="maleo-blog_thumb" href="{{url('get_product?product_id='.$product->product_id."&operator_id=".$product->operator_id)}}"><img src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
                    @endif
                    <div class="maleo-blog_rightcontent">
                        @if($product->operator_id==null)
                        <h3 class="blog-title"><a href="{{url('get_brand?brand_id='.$product->brand_id)}}">{{$product->brand_name}}</a></h3>
                        @else
                        <h3 class="blog-title"><a href="{{url('get_brand?brand_id='.$product->brand_id."&operator_id=".$product->operator_id)}}">{{$product->brand_name}}</a></h3>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="load" style="position: fixed;top: 40%;right:50%"><img src="{{url('images/loading.gif')}}" width="10%"/></div>
    </div>
</div>
@stop
@section('script2')
<script>
    var start = 0;
    var action = 'inactive';
    $('.load').hide();
    $(window).on("scroll", function () {
        if ($(window).scrollTop() + $(window).height() > $(".content-container").height() && action == 'inactive') {
            $('.load').show();
            action = 'active';
            start = start + {{pagination_limit()}};
            setTimeout(function () {
                load_country_data(start);
            }, 500);
        }

    });
    function load_country_data(start)
    {
        $.ajax({
            type: 'GET',
            url: window.location.href + "&start=" + start,
            success: function (data) {
                if (data.count == 0) {
                    action = 'active';
                }
                else {
                    $('.pages').append(data.html);
                     action = 'inactive';
                }
                $('.load').hide();
            }, error: function (data) {

            },
        })
    }
</script>
@stop

