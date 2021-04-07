<div class="btn-group">
    <a class="btn btn-sm show-tooltip" title="" href="{{url("products/$value->id/edit")}}" data-original-title="Edit"><i
            class="fa fa-edit"></i></a>
    {!! Form::open(["url"=>"products/$value->id","method"=>"delete","onsubmit" => "return ConfirmDelete()"]) !!}
    <button type="submit" class="btn btn-sm btn-danger show-tooltip"><a class="show-tooltip"
            data-original-title="Delete"><i class="fa fa-trash-o"></i></a></button>
    {!! Form::close() !!}
    <?php
    $post = \App\Post::where('product_id',$value->id)->count();
    ?>
    @if($post>0)
    <a class="btn btn-sm show-tooltip" href="{{url("post?product_id=$value->id")}}" title="Posts"><i
            class="fa fa-list"></i></a>
    @endif
    <a class="btn btn-sm btn-success show-tooltip" title="" href="{{url("post/$value->id")}}"
        data-original-title="Add Post"><i class="fa fa-plus"></i></a>
</div>
