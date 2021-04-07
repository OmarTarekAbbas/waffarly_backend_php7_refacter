@extends('template')
@section('page_title')
    Brands
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-title">
                        <h3><i class="fa fa-table"></i>Brands Table</h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <div class="btn-toolbar pull-right">
                            <div class="btn-group">
                                <a class="btn btn-circle show-tooltip" title="" href="{{url('brands/create')}}" data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <br><br>
                        <div class="table-responsive" style="border:0">
                            <table class="table table-advance" id="table1">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Brand Image</th>
                            <th>Brand Name</th>
                            <th >Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                             <tr>
                                <td>{{$brand->id}}</td>
                                <td>
                                    {!! Form::label('brand_name',$brand->brand_name) !!}
                                </td>
                                <td>
                                    <img src="{{url('uploads/'.$brand->image)}}" class="img-circle" width="160px" height="160px">
                                </td>
                                <td class="visible-md visible-lg">
                                    <div class="btn-group">
                                        {!! Form::open(["url"=>"brands/$brand->id","method"=>"delete","onsubmit" => "return ConfirmDelete()"]) !!}
                                        <a class="btn btn-sm show-tooltip" title="" href="{{url("brands/$brand->id/edit")}}" data-original-title="Edit"><i class="fa fa-edit"></i></a>
                                        {!! Form::button('<a class="show-tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>',['type'=>'submit','class'=>'btn btn-sm btn-danger show-tooltip']) !!}
                                        <a class="btn btn-sm show-tooltip btn-success"  title="" href="{{url("productsPatch/create?brand_id=$brand->id")}}" data-original-title="Add Products"><i class="fa fa-plus"></i></a>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
