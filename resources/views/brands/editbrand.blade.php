@extends('template')
@section('page_title')
Brands
@stop
@section('content')
@include('errors')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i>Edit Form</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="box-content">
                {!! Form::open(["url"=>"brands/$brand->id","class"=>"form-horizontal","method"=>"patch",'files'=>'true']) !!}
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Brand</label>
                    <div class="col-sm-9 col-lg-10 controls">
                        {!! Form::text('brand_name',$brand->brand_name,['placeholder'=>'Brand Name','class'=>'form-control input-lg','required' => 'required']) !!}
                        <span class="help-inline">Enter a new brand name</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Image</label>
                    <div class="col-sm-9 col-lg-10 controls">
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new img-thumbnail" style="width: 200px; height: 150px;">
                                <img src="{{url('uploads/'.$brand->image)}}" alt="" />
                            </div>
                            <div class="fileupload-preview fileupload-exists img-thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                <span class="btn btn-default btn-file"><span class="fileupload-new">Select image</span>
                                    <span class="fileupload-exists">Change</span>
                                    {!! Form::file('image') !!}</span>
                            </div>
                        </div>
                        <span class="label label-important">NOTE!</span>
                        <span>Only extension supported jpg, png, and jpeg</span>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                        {!! Form::button('<i class="fa fa-check"></i> Save',['type'=>'submit','class'=>'btn btn-primary']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

    </div>

</div>

@stop
@section('script')
<script>
    $('#brand').addClass('active');
    $('#brand-index').addClass('active');
</script>
@stop
