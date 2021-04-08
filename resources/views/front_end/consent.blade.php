<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        a {
            display: block;
            width: 250px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background: #080;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            padding: 20px;
            color: #fff;
            text-decoration: none
        }
    </style>
    
<?php

// $digest = "GCLOGWWB3FgsDKA11Dwc:d08a80a061790f9bf73d7f38444b16cc174810cc6c7d2f277eec71dbf6f00e60" ;
$date=gmdate("Y-m-d H:i:s\Z");
$lang="ar";
$theme="light";
$publicKey="GCLOGWWB3FgsDKA11Dwc";
$privateKey="YSSd8msGWd0XTpZ94KZN";
$message =$date.$lang.$theme;
$digest=$publicKey.":".hash_hmac("sha256",$message ,$privateKey);
$js ="http://lookup.tpay.me/idxml.ashx/js-staging?date=".$date."&lang=".$lang."&theme=".$theme."&digest=".$digest;

?>

<script src="<?php echo $js;?>"></script>
<script>
 try{
      AddSubscriptionContractRequest() ;   
 }
 catch(e)
 {
     alert(e.message);
 }

</script>
    
</head>
<body>
    <a href="">Subscribe</a>
</body>
</html>