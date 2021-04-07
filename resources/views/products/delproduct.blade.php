@extends('template')
@section('page_title')
    Archived Old Products
@stop
@section('content')
@include('errors')
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-title">
                <h3><i class="fa fa-bars"></i>Archive Old Products Form</h3>
                <div class="box-tool">
                    <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                    <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                </div>
            </div>
            <div class="box-content">
                {!! Form::open(['url'=>'products/deleteOld','class'=>'form-horizontal','files'=>'true']) !!}
                <div class="form-group">
                    <label class="col-sm-4 col-lg-4 control-label">Archive Products less than or equal date :</label>
                    <div class="col-sm-5 col-lg-3 controls">
                        <div class="input-group date date-picker" data-date="\Carbon\Carbon::now()->format('d/m/Y')" data-date-format="dd/mm/yyyy" data-date-viewmode="years">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>                               
                            {!! Form::text('form_date',\Carbon\Carbon::now()->format('d/m/Y'),['class'=>'form-control date-picker','required' => 'required', 'size'=>'16','data-date-format'=>'dd/mm/yyyy']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-7 col-sm-offset-5 col-lg-10 col-lg-offset-4">
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
    $('#product-delete').addClass('active');
</script>
@stop