@foreach ($products as $product)
<div class="categories-list">
    <div class="maleo-card maleo-blog_small margin-bottom_low animated">
        <h3 class="blog-title productName"><a href="{{route('product' , ['id' => $product->id])}}"
                class="link_href">{{$product->title}}</a>
        </h3>
        <a class="maleo-blog_thumb link_href" href="{{route('product' , ['id' => $product->id])}}"><img
                src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
        <div class="maleo-blog_rightcontent">
            <h3 class="blog-title"><a href="{{route('category' , ['id' => $product->category_id])}}"
                    class="link_href">{{$product->category_name}}</a>
            </h3>
        </div>
    </div>
</div>

@foreach
