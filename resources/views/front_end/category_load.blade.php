@if(! empty( $products ) && $products != -1 )
@foreach($products as $index=>$product)

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
@endif

