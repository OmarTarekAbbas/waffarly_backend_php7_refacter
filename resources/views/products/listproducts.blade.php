
@extends('template')
@section('page_title')
List of products
@stop
@section('content')
<div id="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-black">
                <div class="box-title">
                    <h3><i class="fa fa-table"></i> Products Table</h3>
                    <div class="box-tool">
                        <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                        <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="btn-toolbar pull-right">
                        <div class="btn-group">
                            <a class="btn btn-circle show-tooltip" title="" href="{{url('products/create')}}" data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <br><br>


                    <div class="table-responsive" style="border:0">
                        <table  class="table table-striped table-bordered dt-responsive products_data" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Product Image</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Active</th>
                                    <th>Featured</th>
                                    <th>Show Date</th>
                                    <th class="visible-md visible-lg" style="width:130px">Action</th>
                                </tr>
                            </thead>
                            <tbody>



                            </tbody>
                        </table>
                    </div>
                </div></div></div></div></div>
@stop
@section('script')
<script>
    $('#product').addClass('active');
    $('#product-index').addClass('active');
    $(document).ready(function () {
        $('.products_data').DataTable({
            "processing": true,
            "serverSide": true,
            ajax: "{!! url('list_products/allData') !!}",
            columns: [
                {data: 'id'},
                {data: 'title',name:'title'},
                {data: 'product_image', searchable: false},
                {data: 'category',name:'category.category_name'},
                {data: 'brand',name:'brand.brand_name'},
                {data: 'active',name:'active'},
                {data: 'featured',name:'featured'},
                {data: 'show_date',name:'show_date'},
                {data: 'action', searchable: false}

            ]
             , "pageLength": '10'
        });
    });
</script>
@stop
