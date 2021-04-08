
@if(! empty( $products ) && $products != -1 )
    @foreach($products as $index=>$product)
        <div class="categories-list">
            <div class="maleo-card maleo-blog_small margin-bottom_low animated">
                @if(isset($product->operator_id))
                <h3 class="blog-title productName"><a href="{{url('get_product?product_id='.$product->product_id.'&operator_id='.$product->operator_id)}}">{{$product->prod_title}}</a></h3>
                <a class="maleo-blog_thumb" href="{{url('get_product?product_id='.$product->product_id.'&operator_id='.$product->operator_id)}}"><img src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
                @else
                <h3 class="blog-title productName"><a href="{{url('get_product?product_id='.$product->product_id)}}">{{$product->prod_title}}</a></h3>
                <a class="maleo-blog_thumb" href="{{url('get_product?product_id='.$product->product_id)}}"><img src="{{url('uploads/'.$product->product_image)}}" class="img-circle" alt=""></a>
                @endif
                <div class="maleo-blog_rightcontent">
                    @if(isset($product->operator_id))

                    <h3 class="blog-title"><a href="{{url('get_category?category_id='.$product->category_id.'&operator_id='.$product->operator_id)}}">{{$product->category_name}}</a></h3>
                    @else

                    <h3 class="blog-title"><a href="{{url('get_category?category_id='.$product->category_id)}}">{{$product->category_name}}</a></h3>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
@endif
