<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('api/etisalat/notification')}}" method="post">
        <input type="text" name="msisdn" value="{{request()->msisdn}}" hidden>
        <input type="submit" value="click to subscribe">
    </form>
</body>
</html>