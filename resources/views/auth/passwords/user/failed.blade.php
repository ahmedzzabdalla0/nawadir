<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app1.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

    <div class="container">
        <div class="row justify-content-center align-content-center" style="height: 100vh;">
            <div class="col-md-8">
                <h1 class="text-center">{{config('app.name')}}</h1>
                <div class="card">
                    <div class="card-header text-center">
                        <span>Reset Password</span>
                        <span> - </span>
                        <span>اعادة تعيين كلمة المرور</span>
                    </div>
                    <div class="card-body text-center">
                        <h2 class="text-center" style="color: #662d21">فشلت عملية اعادة تعيين كلمة المرور</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>

