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
                <img src="{{asset('admin/imgs/logo_w.png')}}" style="width: 160px;display: block;margin: auto;" alt="">
                <h1 class="text-center">{{config('app.name')}}</h1>
                <div class="card">
                    <div class="card-header text-center">
                        <span>Reset Password</span>
                        <span> - </span>
                        <span>اعادة تعيين كلمة المرور</span>
                    </div>
                    <div class="card-body text-center">
                        <form method="POST" action="{{ route('user.password.reset') }}"
                              aria-label="اعادة تعيين كلمة المرور - Reset Password">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-3 col-form-label text-left"> Email Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control text-center {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ $email ?? old('email') }}" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <label for="email"
                                       class="col-md-3 col-form-label text-right">البريد الالكتروني </label>
                            </div>
                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-3 col-form-label text-left"> Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control text-center {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <label for="password"
                                       class="col-md-3 col-form-label text-right">كلمة المرور </label>
                            </div>
                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-3 col-form-label text-left"> Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control text-center "
                                           name="password_confirmation" required>
                                </div>
                                <label for="password-confirm"
                                       class="col-md-3 col-form-label text-right">تأكيد كلمة المرور </label>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <span>Reset Password</span>
                                        <span> - </span>
                                        <span>تغيير كلمة المرور</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>

