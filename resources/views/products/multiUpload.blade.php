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
                <h3><i class="fa fa-bars"></i>Add Product Form</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="box-content">
                <a class="btn btn-default btn-sm pull-right" href="{{url('productsPatch/template_excel')}}" >
                    Download Template Excel
                </a>
                <br/>
                {!! Form::open(['url'=>'productsPatch/Upload','class'=>'form-horizontal','files'=>'true']) !!}
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Products File</label>
                    <div class="col-sm-9 col-lg-10 controls">

                        {!! Form::file('file',['required'=>'required']) !!}</span>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Select Category</label>
                    <div class="col-sm-9 col-sm-10 controls">
                        {!! Form::select('category_id',$categories,null,['class'=>'form-control chosen','required'=>'required']) !!}
                    </div>
                </div>
                @if($brandID)
                <input type="hidden" name="brand_id" value="{{$brandID}}"/>
                @else    
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Select Brand</label>
                    <div class="col-sm-9 col-sm-10 controls">
                        {!! Form::select('brand_id',$brands,null,['class'=>'form-control chosen','required'=>'required']) !!}
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Active Or Not</label>
                    <div class="col-sm-9 col-lg-10 controls">
                        <label class="radio">
                            <div id="mySwitch1" class="make-switch switch-small" data-on-label="YES" data-off-label="NO">
                                <input type="checkbox"   />
                            </div>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Featured Or Not</label>
                    <div class="col-sm-9 col-lg-10 controls">
                        <label class="radio">
                            <div id="mySwitch" class="make-switch switch-small" data-on-label="YES" data-off-label="NO">
                                <input type="checkbox"   />
                            </div>
                        </label>
                    </div>
                </div>
                <input type="hidden" name="active" value="0">
                <input type="hidden" name="featured" value="0">
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Show that product at date :</label>
                    <div class="col-sm-5 col-lg-3 controls">
                        <div class="input-group date date-picker" data-date="\Carbon\Carbon::now()->format('d/m/Y')" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>                               
                            {!! Form::text('show_date',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>'form-control date-picker','required' => 'required', 'size'=>'16','data-date-format'=>'dd/mm/yyyy']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 col-lg-2 control-label">Expire date  :</label>
                    <div class="col-sm-5 col-lg-3 controls">
                        <div class="input-group date date-picker" data-date="\Carbon\Carbon::now()->format('d/m/Y')" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>                               
                            {!! Form::text('expire_date',\Carbon\Carbon::tomorrow()->format('d/m/Y'),['class'=>'form-control date-picker','required' => 'required', 'size'=>'16','data-date-format'=>'dd/mm/yyyy']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                        {!! Form::button('<i class="fa fa-check"></i> Save' ,['type'=>'submit','class'=>'btn btn-primary']) !!}
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
    $('#product').addClass('active');
    $('#product-patch').addClass('active');
</script>
@stop