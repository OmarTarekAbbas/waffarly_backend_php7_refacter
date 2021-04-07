@extends('template')
@section('page_title')
Products
@stop
@section('content')
@include('errors')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i>Edit Product Form</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="box-content">
                {!! Form::open(["url"=>"products/$product->id","class"=>"form-horizontal","files"=>"true","method"=>"patch"]) !!}
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Product Image</label>
                    <div class="col-sm-9 col-lg-10 controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                <img src="{{url('uploads/'.$product->product_image)}}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span>
                                    <span class="fileupload-exists">Change</span>
                                    {!! Form::file('product_image') !!}</span>
                            </div>
                        </div>
                        <span class="label label-important">NOTE!</span>
                        <span>Only extension supported jpg, png, and jpeg</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Select Category</label>
                    <div class="col-sm-9 col-sm-10 controls">
                        {!! Form::select('category_id',$categories,$product->category->id,['class'=>'form-control chosen',"required"=>"required"]) !!}
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Select Brand</label>
                    <div class="col-sm-9 col-sm-10 controls">
                        {!! Form::select('brand_id',$brands,$product->brand->id,['class'=>'form-control chosen',"required"=>"required"]) !!}
                    </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Active Or Not</label>
                    <div class="col-sm-9 col-sm-10 controls">
                        <label class="radio">
                            <div id="mySwitch1" class="make-switch switch-small" data-on-label="YES" data-off-label="NO">
                                <input type="checkbox" {{($product->active) ? 'checked':''}}  />
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Featured Or Not</label>
                    <div class="col-sm-9 col-sm-10 controls">
                        <label class="radio">
                            <div id="mySwitch" class="make-switch switch-small" data-on-label="YES" data-off-label="NO">
                                <input type="checkbox" {{($product->featured) ? 'checked':''}}  />
                            </div>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="active" value="{{$product->active}}">
                <input type="hidden" name="featured" value="{{$product->featured}}">
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Show that product at date :</label>
                    <div class="col-sm-5 col-lg-3 controls">
                            {!! Form::text('show_date',($product->show_date) ?\Carbon\Carbon::createFromFormat('Y-m-d', $product->show_date)->format('d/m/Y') : \Carbon\Carbon::now()->format('d/m/Y'),['class'=>'form-control date-picker','required' => 'required', 'size'=>'16','data-date-format'=>'dd/mm/yyyy']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Expire date  :</label>
                    <div class="col-sm-5 col-lg-3 controls">
                            {!! Form::text('expire_date',($product->expire_date) ?\Carbon\Carbon::createFromFormat('Y-m-d', $product->expire_date)->format('d/m/Y') : \Carbon\Carbon::now()->format('d/m/Y'),['class'=>'form-control date-picker','required' => 'required', 'size'=>'16','data-date-format'=>'dd/mm/yyyy']) !!}
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                        {!! Form::button('<i class="fa fa-check"></i> Save' ,['type'=>'submit','class'=>'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div></div>
@stop
@section('script')
<script>
    $('#product').addClass('active');
    $('#product-index').addClass('active');
</script>
@stop
