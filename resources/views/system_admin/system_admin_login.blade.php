<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>نوادر القصيم | تسجيل الدخول</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Montserrat:300,400,500,600,700","Roboto:300,400,500,600,700","Cairo:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Web font -->

    <link href="{{asset('admin/assets/vendors/base/vendors.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('admin/assets/demo/demo3/base/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('admin/admin.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <link href="{{asset('admin/nice-select.css')}}" rel="stylesheet" type="text/css"/>


    <link rel="shortcut icon" type="image/png" href="{{asset('admin/imgs/logo_w.png')}}"/>
    <!--end::Global Theme Styles -->
    @yield('head')
    <style>
        .btn.btn-success {
            color: #fff;
            background-color: #98C561;
            border-color: #98C561;
        }

        .btn.btn-success:hover, .btn.btn-success:hover:not(:disabled) {
            background-color: #fff;
            color: #000 !important;
            border-color: #98C561;
            /*webkit-box-shadow: 0px 5px 10px 2px #0ED8CA !important;*/
            /*box-shadow: 0px 5px 10px 2px #0ED8CA !important;*/
        }

        .btn.btn-success:active {
            background-color: #fff;
            color: #000 !important;
            border-color: #98C561;
        }
    </style>
</head>

<!-- end::Head -->

<body style="background-color:#fff;" class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-2" id="m_login">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo" style="margin: 0px!important;">
                    <a href="#">
                        <img src="{{asset('admin/imgs/logo_w.png')}}" style="width: 250px;">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title" style="color: #202039;font-size: 24px;">تسجيل الدخول (الإدارة)</h3>
                    </div>
                    <form class="m-login__form m-form" method="post" action="{{route('system_admin.login')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group m-form__group">

                            <input class="form-control m-input" type="text" placeholder="اسم المستخدم" name="email" autocomplete="off">
                            
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="كلمة المرور" name="password"  autocomplete="off">
                            @show_error("email")
                        </div>

                        <div class="m-login__form-action">
                            <button class="btn btn-success m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">تسجيل الدخول</button>
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>
</div>


<script src="{{asset('admin/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/assets/demo/demo3/base/scripts.bundle.js')}}" type="text/javascript"></script>

@include('flash::message')

</body>



