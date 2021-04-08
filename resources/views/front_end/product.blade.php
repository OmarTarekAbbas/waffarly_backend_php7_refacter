@extends('front_template')
@section('front_content')
        <div id="page">
            @extends('top_navbar')
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                <div class="pages product-page">
                    <div class="maleo-card product-single animated fadeInUp">
                    <div class="product-price"><h3>{{$product[0]->title}}</h3></div>
                        <div class="thumb"><img src="{{url('uploads/'.$product[0]->product_image)}}" class="img-circle" alt=""></div>
                        <!-- Product header contain product name, price & rating-->
                        <div class="product-header">
                            @if(isset($product[0]->operator_id))
                                <div class="product-price"><a href="{{'get_brand?brand_id='.$product[0]->brand_id."&operator_id=".$product[0]->operator_id}}" class="product-price_reduced">{{$product[0]->brand_name}}</a></div>
                                <div class="product-price"><a href="{{'get_category?category_id='.$product[0]->category_id."&operator_id=".$product[0]->operator_id}}" class="product-price_reduced">{{$product[0]->category_name}}</a></div>
                            @else
                                <div class="product-price"><a href="{{'get_brand?brand_id='.$product[0]->brand_id}}" class="product-price_reduced">{{$product[0]->brand_name}}</a></div>
                                <div class="product-price"><a href="{{'get_category?category_id='.$product[0]->category_id}}" class="product-price_reduced">{{$product[0]->category_name}}</a></div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- //HERE IS CONTENTS -->

                @if(! empty( $OtherProducts ) && $OtherProducts != -1 )
                @foreach($OtherProducts as $value)
                    <div class="pages product-page">
                        <div class="maleo-card product-single animated fadeInUp">
                        <div class="product-price"><h3>{{$value->title}}</h3></div>
                             @if(isset($value->operator_id))
                                <a class="thumb" href="{{url('get_product?product_id='.$value->id."&operator_id=".$value->operator_id)}}">

                            @else
                                <a class="thumb" href="{{url('get_product?product_id='.$value->id)}}">
                            @endif
                            <img src="{{url('uploads/'.$value->product_image)}}" class="img-circle" alt="">
                                </a>
                            <!-- Product header contain product name, price & rating-->
                            <div class="product-header">
                                @if(isset($value->operator_id))
                                    <div class="product-price"><a href="{{'get_brand?brand_id='.$value->brand_id."&operator_id=".$value->operator_id}}" class="product-price_reduced">{{$value->brand_name}}</a></div>
                                    <div class="product-price"><a href="{{'get_category?category_id='.$value->category_id."&operator_id=".$value->operator_id}}" class="product-price_reduced">{{$value->category_name}}</a></div>
                                @else
                                    <div class="product-price"><a href="{{'get_brand?brand_id='.$value->brand_id}}" class="product-price_reduced">{{$value->brand_name}}</a></div>
                                    <div class="product-price"><a href="{{'get_category?category_id='.$value->category_id}}" class="product-price_reduced">{{$value->category_name}}</a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
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
                if (data.html == '') {
                    action = 'active';
                }
                else {
                    $('.content-container').append(data.html);
                     action = 'inactive';
                }
                $('.load').hide();
            }, error: function (data) {

            },
        })
    }
</script>
@stop
