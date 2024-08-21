<!DOCTYPE html>
<html lang="en">
<head>
    <title>نوادر القصيم</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('website/images/icons/favicon.ico')}}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('website/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('website/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('website/fonts/iconic/css/material-design-iconic-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('website/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('website/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/main.css')}}">
    <!--===============================================================================================-->
</head>
<body>


<div class="bg-g1 size1" style="background: #fff!important;margin-top: 3%!important;">
    <span></span>
    <div class="flex-col-c p-t-50 p-b-50">
        <img src="{{asset('admin/imgs/logo_w.png')}}" style="width: 150px;"  alt="">
        <h7 class="l1-txt1 txt-center p-t-10" style="font-size:18px;color:#202039;margin:10px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
            لقد انتهت جلسة العمل في لوحة التحكم
        </h7>
        <h7 class="l1-txt1 txt-center p-b-10" style="font-size:18px;color:#202039;margin:10px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
            يرجى اعادة تسجيل الدخول من الرابط أدناه
        </h7>
        <h7 class="l1-txt1 txt-center p-b-10" style="font-size:25px;color:#202039;margin:10px;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
            <a href="{{route('system_admin.login')}}" class="btn btn-success btn-xs">تسجيل الدخول</a>
         </h7>
    </div>

</div>


<!--===============================================================================================-->
<script src="{{asset('website/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('website/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('website/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('website/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('website/vendor/countdowntime/moment.min.js')}}"></script>
<script src="{{asset('website/vendor/countdowntime/moment-timezone.min.js')}}"></script>
<script src="{{asset('website/vendor/countdowntime/moment-timezone-with-data.min.js')}}"></script>
<script src="{{asset('website/vendor/countdowntime/countdowntime.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('website/vendor/tilt/tilt.jquery.min.js')}}"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="{{asset('website/js/main.js')}}"></script>

</body>
</html>
