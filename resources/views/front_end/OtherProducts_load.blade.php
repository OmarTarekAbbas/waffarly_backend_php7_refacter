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
                <img src="{{url($value->product_image)}}" class="img-circle" alt="">
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
