@extends('front_template')
@section('front_content')
        <div id="page">
            @extends('top_navbar')
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                <div class="pages search-page">
                    <h1 class="page-title margin-bottom animated fadeIn">البحث</h1>
                    <!-- Search formfor single page -->
                    <div class="search-form">
                        <input name="searchPro" onkeyup="post_search(this)" type="text" placeholder="أكتب كلمة البحث ..." class="animated fadeInRight">
                    </div>

                    <!--search result can hide this section when no result found-->
                    <div class="categories-list" id="outter_div">

                    </div>
                </div>
                <!-- //HERE IS CONTENTS -->
            </div>
        </div>
@stop
@section('script')
    <script>
        function post_search(input) {
            if (input.value != "")
            {
                <?php
                        if (!isset($_GET['OpID']))
                        {
                ?>
                            $.get('search_result?keyword='+input.value,function (results) {
                                $('#outter_div').html('');
                                $('#outter_div').append('<h1 class="page-title margin-bottom animated fadeIn"> أنت تبحث عن: '+input.value+'</h1>')
                                results.forEach(append_search_result) ;
                            });
                <?php
                        }
                        else{
                ?>
                            $.get('search_result?keyword='+input.value+'&OpID='+'<?php echo $_GET['OpID'] ?>',function (results) {
                                $('#outter_div').html('');
                                results.forEach(append_search_result) ;
                            });
                <?php
                        }
                 ?>
            }
            else{
                $('#outter_div').html('');
            }
        }
    </script>

    <script>
        function append_search_result(record) {

            if (record.category_id) {

                if(record.operator_id){
                    var opId = '&OpID='+record.operator_id ;
                }else{
                    var opId =  "";
                }

                var str = '<div class="maleo-card maleo-blog_small margin-bottom_low animated fadeInUp">\
                        <h3 class="blog-title prod"><a style="  color: #fff !important;" href="{{url('product')}}' +'/'+ record.id +opId+ '" > ' + record.title + ' </a></h3>\
                        <div class="maleo-blog_thumb"><a href="{{url('product')}}' +'/'+ record.id +opId+ '" ><img  class="img-circle" src="{{url("")}}/uploads/' + record.product_image + '" alt=""></a></div>\
                        <div class="maleo-blog_rightcontent">\
                        <h3 class="blog-title">\
                        <a href="{{url('category')}}' +'/'+ record.category_id +opId+ '">' + record.category_name + '</a> /\
                        <a href="{{url('brand')}}' +'/'+ record.brand_id + opId+'">' + record.brand_name + '</a>\
                        </h3>\
                        </div>\
                        </div>';
                $('#outter_div').append(str);
            }
        }
    </script>
@stop
