<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>نوادر القصيم | @yield('title')</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="{{asset('admin/admin.css')}}" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <link href="{{asset('admin/nice-select.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin/m-custom.css')}}" rel="stylesheet" type="text/css"/>



    <link rel="shortcut icon" type="image/png" href="{{asset('admin/imgs/logo_w.png')}}"/>
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('admin/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
    <link href="{{asset('croper/cropper.css')}}" rel="stylesheet">
    <script src="{{asset('croper/cropper.min.js')}}"></script>
    <!--end::Global Theme Styles -->
    @yield('head')
</head>

<!-- end::Head -->
