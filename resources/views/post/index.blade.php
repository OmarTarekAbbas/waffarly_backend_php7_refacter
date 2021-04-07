@extends('template')
@section('page_title')
 Post
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-12">
                <div class="box box-black">
                    <div class="box-title">
                        <h3><i class="fa fa-table"></i> Post Table</h3>
                        <div class="box-tool">
                            <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                            <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <div class="btn-toolbar pull-right">
                            <div class="btn-group">
                                <a class="btn btn-circle show-tooltip" title="" href="{{url('post/create')}}" data-original-title="Add new record"><i class="fa fa-plus"></i></a>
                                <?php
                                $table_name = "posts";
                                // pass table name to delete all function
                                // if the current route exists in delete all table flags it will appear in view
                                // else it'll not appear
                                ?>
                                @include('partial.delete_all')
                            </div>
                        </div>
                        <br><br>
                        <div class="table-responsive">
                            <table id="dtposts" class="table table-striped dt-responsive" cellspacing="0" width="100%">

                                <thead>
                                    <tr>
                                        <th style="width:18px"><input type="checkbox" onclick="select_all('posts')"></th>
                                        <th>content</th>
                                        <th>published date</th>
                                        <th>Status</th>
                                        <th>url</th>
                                        <th>user</th>
                                        <th >Action</th>
                                    </tr>
                                </thead>
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


$('#post').addClass('active');
$('#post_index').addClass('active');

</script>

<script>
    window.onload = function() {
        $('#dtposts').DataTable({
            "processing": true,
            "serverSide": true,
            //"search": {"regex": true},
            "ajax": {
            type: "GET",
            "url": "{!! url('post/allData?post_id=') !!}{{isset($post)? $post->id : ''}}",
            "data":"{{csrf_token()}}"
            },
            columns: [
            {data: 'index', searchable: false, orderable: false},
            {data: 'content'},
            {data: 'published_date'},
            {data: 'Status'},
            {data: 'url'},
            {data: 'user'},
            {data: 'action', searchable: false}
            ]
            , "pageLength": 5
        });
    };
    </script>

@stop
