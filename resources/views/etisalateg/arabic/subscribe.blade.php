@extends('mobilysa.arabic.master')

@section('language')

@stop
@section('title')
    <title>البوابة الاسلامية|اشتراك</title>
@stop

@section('serviceLogo')
    <li class="flex-container row-center-vertical flex-right service-logo make-sticky">
        <h1 class="flex-col-3">اشتراك</h1>
        <div class="flex-col-1 logo-img">
            <img src="{{asset('img/WebApps/ooredoo/afasy/logo.png')}}"/>
        </div>
    </li>
@stop
@section('content')
    <section class="subscribe main-container-wrapper">
        <a class="form-btn show-terms">شروط الاشتراك</a>
        <div class="check-terms">
            <ul class="terms">
                <p>By subscribing to the service, you are accepting all Terms & Conditions of the service & authorize Ooredoo to share your mobile number with our partner IVAS, who manages this subscription service.
                    You can choose from the below options to subscribe to Al Afasy service:</p>

                <li>To subscribe to Daily Plan, send afasy d to 92815</li>
                <li>To subscribe to Weekly Plan, send afasy to 92815</li>

                <li>All new user can enjoy 7 Days Free Trial upon activation.  Please note that, if you have already enjoyed FREE TRIAL in the past, you will be charged as per the subscription plan you have selected.</li>

                <li>Your subscription to Al Afasy service is automatically renewed, until you deactivate the service.</li>

                <li>By subscribing to Al Afasy service, you accept to receive renewal and content recommendation alert through SMS.</li>

                <li>Data charges apply for browsing & downloading contents on this portal.</li>

                <li>If you wish to deactivate or un-subscribe from the service, send UNAfasy to 92815.</li>

                <li>If you are an iOS device user, downloading of Videos and Ringtones are not allowed, but you can stream it on your device.</li>

                <li>If your subscription renewal attempts are unsuccessful for 30 days in a row, then your subscription will be deactivated automatically on 31st day.</li>

                <li>To make use of this service, one must be more than 18 years old or have received permission from your parents or person who is authorized to pay your mobile bill.</li>
            </ul>
            <!--<form>
                <input type="checkbox"/>
                <label>I agree to the terms and conditions.</label>

            </form>-->
        </div><!-- end check terms-->

        <div class="subscriber-wrapper">
            <div class="weekly-plan">

                    <a href="{{url('2/subscribeW')}}" class="form-btn">اشترك</a>

                            <!--<h3>Weekly Plan</h3>-->
            </div>

        </div><!-- end subscribe wrapper -->
    </section>
@stop