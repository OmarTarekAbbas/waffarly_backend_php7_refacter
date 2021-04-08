@extends('front_template')
@section('front_content')
        <div id="page">
            @extends('top_navbar')
            <div class="content-container">
                <!-- HERE IS CONTENTS -->
                <div class="pages terms-page">
                    <div class="maleo-card maleo-article animated fadeInUp">
                        <div class="post-header">
                            <h1 class="entry-title_page">سياسة الموقع</h1>
                        </div>
                        <div class="blog-content">
                            <div class="terms">
                                {!! $result->value !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //HERE IS CONTENTS -->
            </div>
        </div>
@stop
