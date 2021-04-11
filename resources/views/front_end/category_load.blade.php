@foreach($products as $index=>$product)
<div class="categories-list">
    <div class="maleo-card maleo-blog_small margin-bottom_low animated">
        <h3 class="productName"><a href="{{route('product' , ['id' => $product->id])}}">{{$product->title}}</a></h3>
        <a class="maleo-blog_thumb" href="{{route('product' , ['id' => $product->id])}}"><img src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
        <div class="maleo-blog_rightcontent">
            <h3 class="blog-title"><a href="{{route('brand' , ['id' => $product->brand_id])}}">{{$product->brand_name}}</a></h3>
        </div>
    </div>
</div>
@endforeach

