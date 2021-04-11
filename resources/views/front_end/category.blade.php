@extends('front_template')
@section('front_content')
<div id="page">
    @extends('top_navbar')
    <div class="content-container">
        <!-- HERE IS CONTENTS -->
        <div class="pages brand-page">
            @forelse($products as $index=>$product)
            @if($index==0)
            <h1 class="page-title margin-bottom animated fadeIn">{{$product->category_name}}</h1>
            @endif
            <div class="categories-list">
                <div class="maleo-card maleo-blog_small margin-bottom_low animated">
                    <h3 class="productName"><a
                            href="{{route('product' , ['id' => $product->id])}}" class="link_href">{{$product->title}}</a>
                    </h3>
                    <a class="maleo-blog_thumb"
                        href="{{route('product' , ['id' => $product->id])}}" class="link_href"><img
                            src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
                    <div class="maleo-blog_rightcontent">
                        <h3 class="blog-title"><a
                                href="{{route('brand' , ['id' => $product->brand_id])}}" class="link_href">{{$product->brand_name}}</a>
                        </h3>
                    </div>
                </div>
            </div>
            @empty
            @include("front_end.not-found")
            @endforelse
        </div>
        <div class="load" style="position: fixed;top: 40%;right:50%"><img src="{{url('images/loading.gif')}}"
                width="10%" /></div>
    </div>
</div>
@stop
@section('script2')
<script>
var start = 1;
var action = 'inactive';
$('.load').hide();
$(window).on("scroll", function() {
    if ($(window).scrollTop() + $(window).height() > $(".content-container").height() && action == 'inactive') {
        $('.load').show();
        action = 'active';
        start = start + 1;
        setTimeout(function() {
            load_country_data(start);
        }, 500);
    }

});

function load_country_data(start) {
    var opid = "{{request()->get('OpID')}}";
    if (opid) {
        var url = window.location.href + "&page=" + start
    } else {
        var url = window.location.href + "?page=" + start
    }
    $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
            if (data.count == '') {
                action = 'active';
            } else {
                $('.pages').append(data.html);
                action = 'inactive';
            }
            $('.load').hide();
        },
        error: function(data) {

        },
    })
}
</script>
@stop
