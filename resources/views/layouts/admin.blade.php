<!DOCTYPE html>
<html  lang="en"  direction="rtl" style="direction: rtl;">

@include('layouts.parts.head')

<!-- begin::Body -->
{{--<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">--}}
<body class="m-page--fluid m--skin- m-page--loading-enabled m-content--skin-light2 m-header--static m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default" dir="rtl">
<div style="background: #fff;position: fixed;top: 0;bottom: 0;right: 0;left: 0;z-index: 1000;display: block;" id="PageLoader">
    <div class="m-blockui" style="margin: 45vh auto;">
        <span>الرجاء الانتظار...</span>
        <span><div class="m-loader m-loader--brand"></div></span>
    </div>
</div>
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">

   @include('layouts.parts.header')

    <!-- begin::Body -->
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

    @include('layouts.parts.side')
        <div class="m-grid__item m-grid__item--fluid m-wrapper">
    @yield('page_content')
        </div>

        <!-- END: Left Aside -->

    </div>

    <!-- end:: Body -->

    @include('layouts.parts.footer')
</div>

<div class="modal" id="AddNewModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">اضافة جديد</h4>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="RetSelect" class="RetSelect">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        @component('components.input',['name'=>'name_ar_to_add','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                        @endcomponent
                    </div>
                    <div class="w-100" style="display: none"></div>
                    <div class="col-md-8" style="display: none">
                        @component('components.input',['name'=>'name_en_to_add','text'=>'name','placeholder'=>'Enter the name','icon'=>'fa-user-alt'])
                        @endcomponent
                    </div>
                    <div class="w-100"></div>

                        <button type="button"
                                class="btn m-btn--pill m-btn--air btn-outline-info m-btn m-btn--custom btn_addToList">
                            <i class="fa fa-plus"></i>
                            <span>اضافة</span>
                        </button>
                </div>
            </div>


        </div>
    </div>
</div>
<!-- end:: Page -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->


<script src="{{asset('admin/assets/demo/demo3/base/scripts.bundle.js')}}" type="text/javascript"></script>


<script>
    UrlForScripts='{{url('/')}}';
    UrlForAssets='{{url('/')}}';
</script>

<script src="{{asset('admin/main.js')}}" type="text/javascript"></script>

<script type="text/javascript" src="{{asset('admin/jquery.nicescroll.min.js')}}" ></script>

<script src="{{asset('admin/jquery.nice-select.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/sweetalert2.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/jquery-validation/js/localization/messages_ar.min.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/jquery.minicolors.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{asset('admin/datepicker/locales/bootstrap-datepicker.ar.min.js')}}" type="text/javascript"></script>
@yield('custom_scripts')

<script>
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });

        $(function () {
            $('#PageLoader').fadeOut(800);
        })
        $('select:not(.no_nice_select)').niceSelect();
        {{--$(".nice-select").on('click',function () {--}}

        {{--    // if($(this).hasClass('open')){--}}

        {{--    var list = $(this).children('.list');--}}


        {{--    list.on('scroll',function () {--}}
        {{--        list.niceScroll({railalign: '{{app()->getLocale() == 'ar'?'left':'right'}}'});--}}
        {{--    });--}}
        {{--    list.on('scroll',function () {--}}
        {{--        list.css("padding", "1");--}}
        {{--        list.css("overflow", "scroll");--}}
        {{--        list.css("outline", "unset");--}}
        {{--    });--}}
        {{--    // }else{--}}
        {{--    //     $("div[id^='ascrail']").hide();--}}
        {{--    // }--}}

        {{--});--}}
        if($('.summernote').length >0) {
            $('.summernote').summernote({
                height: 150
            });
        }

        if($('.input-daterange').length >0){
            $('.input-daterange').datepicker({
                rtl: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
        }
        if($('[data-provide="datepicker"]').length >0){
            $('[data-provide="datepicker"]').datepicker({
                format: 'yyyy-mm-dd',
                language:'ar',
                todayHighlight:true,
                weekStart:6
            });
        }


    });


</script>
@include('flash::message')


{{-- Pusher --}}

@include('layouts.parts.pusher')




<div class="AjaxLoad">
    <div class="m-blockui" style="margin: 45vh auto;">
        <span>الرجاء الانتظار...</span>
        <span><div class="m-loader m-loader--brand"></div></span>
    </div>
</div>

</body>

<!-- end::Body -->
</html>
