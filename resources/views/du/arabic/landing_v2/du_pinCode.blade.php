@extends('landing_v2.template_zain_ksa')
@section('section')

  <div class="confirm_page">
    <img src="{{ url('assets/front/landing_v2')}}/img/logo.png" alt="snap">

    <div class="container">

        <div class="confirm">

            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('success')}}
            </div>
            @elseif(Session::has('failed'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                {{ Session::get('failed')}}
            </div>
            @endif

            <h2>ادخل كود التفعيل</h2>
            <hr>
           {!! Form::open(['url'=>'mobily_ksa_pincode_confirm','method'=>'post','class'=>'form','files'=>'true']) !!}
                <div class="form-group">
                      <input type="tel" name="pincode"   class="form-control" id="pincode" required pattern="[0-9]{6}">
                </div>
                <input type="hidden"  name="msisdn" value="">

                <button class="btn" type="submit" >تاكيد</button>
             {!! Form::close() !!}
        </div>
    </div>

    <div id="loginModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-right">
                    <div class="alert alert-success" role="alert">تم تاكيد الكود بنجاح</div>
                </div>
            </div>
        </div>
    </div>

</div>

@stop
