@extends('front_template')
@section('front_content')
<div id="page">
    @extends('top_navbar')
    <div class="content-container">
        <!-- HERE IS CONTENTS -->
        <div class="pages brand-page">
            <h1 class="page-title margin-bottom animated fadeIn">{{$brand->brand_name}}</h1>
            @forelse ($products as $product)
            <div class="categories-list">
                <div class="maleo-card maleo-blog_small margin-bottom_low animated">
                    <h3 class="blog-title productName"><a
                            href="{{route('product' , ['id' => $product->id])}}" class="link_href">{{$product->title}}</a>
                    </h3>
                    <a class="maleo-blog_thumb link_href" href="{{route('product' , ['id' => $product->id])}}"><img
                            src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
                    <div class="maleo-blog_rightcontent">
                        <h3 class="blog-title"><a
                                href="{{route('category' , ['id' => $product->category_id])}}" class="link_href">{{$product->category_name}}</a>
                        </h3>
                    </div>
                </div>
            </div>
            @empty
            @include("front_end.not-found")
            @endforelse


        </div>
        <!-- //HERE IS CONTENTS -->
        <div class="load" style="position: fixed;top: 40%;right:50%"><img src="{{url('images/loading.gif')}}"
                width="10%" /></div>
    </div>
</div>
<!-- //HERE IS CONTENTS  no chnage -->
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
        start = start + 1
        setTimeout(function() {
            load_country_data(start);
        }, 500);
    }

});


function load_country_data(start) {
        var opid = "{{request()->get('OpID')}}";
        if (opid) {
            var url = window.location.href + "&page=" + start
        }else{
            var url = window.location.href + "?page=" + start
        }
    $.ajax({
        type: 'GET',
        url: url,
        success: function(data) {
            if (data.html == '') {
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
