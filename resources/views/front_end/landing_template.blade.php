<!DOCTYPE html>
<html lang="en">
<head>
    
 <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '261541571464137');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=261541571464137&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126101657-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-126101657-1');
    </script>

    <meta charset="utf-8">
    <!--IE Compatibility Meta-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Mobile Meta-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
	<title>yallawaffar </title>
	
	<link rel="stylesheet" type="text/css" href="{{url('landing_page/css/bootstrap.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('landing_page/css/edit.css')}}">
	<link rel="stylesheet" type="text/css" href="{{url('landing_page/css/style.css')}}">
    <!--[if lt IE 9]>
      <script src="{{url('landing_page/js/html5shiv.min.js')}}"></script>
      <script src="{{url('landing_page/js/respond.min.js')}}"></script>
    <![endif]-->

    <?php
    // $digest = "GCLOGWWB3FgsDKA11Dwc:d08a80a061790f9bf73d7f38444b16cc174810cc6c7d2f277eec71dbf6f00e60" ;
    $date=gmdate("Y-m-d H:i:s\Z");
    $lang="ar";
    $theme="light";
    $publicKey="fhCP5KoWwDET9G9N9odF";
    $privateKey="6g8UUH6mlUilXpOSssp8";
    $message =$date.$lang.$theme;
    $digest=$publicKey.":".hash_hmac("sha256",$message ,$privateKey);
    $js ="http://lookup.tpay.me/idxml.ashx/js?date=".$date."&lang=".$lang."&theme=".$theme."&digest=".$digest;


    ?>

    <script src="<?php echo $js;?>"></script>


    <script>
        msisdn= "" ;
        operatorCode= "" ;
        function TPay_functions() {

            // $("#new_subscriber").css("display","none");

            try{
                TPay.HeaderEnrichment.confirm(514, "yallawaffar", "yallawaffar",
                        function (result, refNo) { // still refNo user is rejected
                            if (result == true){
                                var signature = null ;
                                var session_id = TPay.HeaderEnrichment.sessionId() ;
                                msisdn = TPay.HeaderEnrichment.msisdn();
                                operatorCode=TPay.HeaderEnrichment.operatorCode();

                                /*
                                 alert( "popup is clicked") ;
                                 alert( "session id : "+ TPay.HeaderEnrichment.sessionId()) ;     // integer
                                 alert( "operator code : " +  TPay.HeaderEnrichment.operatorCode()) ;   // 60201
                                 alert( "Msisdn : " +  TPay.HeaderEnrichment.msisdn()) ;
                                 */


                                //  var client_date = {"msisdn":msisdn,"operatorCode":operatorCode} ;

                                $("#new_subscriber").css("display","none");

                                TPay_functions2(refNo);

                            }
                            else{
                                // alert("error is:" + refNo);
                                alert("يوجد خطأ" );
                            }

                        });
                //var session_id = TPay.HeaderEnrichment.sessionId() ;


            }
            catch(e)
            {
                // alert(e.message);
                alert("يوجد خطأ" );
            }

        }
        function TPay_functions2(refNo) {
            $.ajax({
                method: "POST",
                url: "{{url('tpay_subscribe_json')}}",
                data: {"msisdn": msisdn, "operatorCode": operatorCode,"refNo":refNo},

                success: function (result) {
                    data = JSON.parse(result);
                    if(data.val == 1 ||  data.val == 2 || data.val == 3   ){
                        alert(data.message);
                    }else if(data.val == 4){
                        alert("تم الاشتراك بنجاح" );
                        window.location.href = "{{url('/')}}"    ;
                    } else{
                        // alert("fail unknow error");
                        alert("يوجد خطأ" );
                    }
                },
                error: function() {
                    //  alert("ajax error");
                    alert("يوجد خطأ" );
                }
            }) ;

        }
    </script>

</head>

@yield('content')


<script src="{{url('landing_page/js/jquery-3.2.1.min.js')}}"  type="text/javascript"></script>
<script src="{{url('landing_page/js/bootstrap.min.js')}}"  type="text/javascript"></script>
<script src=" {{url('landing_page/js/main.js')}}"  type="text/javascript"></script>

@yield('modal_show')

@yield('check_HE')

</body>
</html>