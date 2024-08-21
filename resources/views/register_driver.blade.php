

<head>
    <meta charset="utf-8" />
    <title>نوادر القصيم | @yield('title')</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    
    <link href="https://nwader.sa/admin/assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link href="https://nwader.sa/admin/assets/demo/demo3/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://nwader.sa/admin/admin.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME LAYOUT STYLES -->
    <link href="https://nwader.sa/admin/nice-select.css" rel="stylesheet" type="text/css"/>
    <link href="https://nwader.sa/admin/m-custom.css" rel="stylesheet" type="text/css"/>
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
    <link rel="shortcut icon" type="image/png" href="https://nwader.sa/admin/imgs/logo_w.png"/>
    <script src="https://nwader.sa/ckeditor/ckeditor.js"></script>
    <script src="https://nwader.sa/admin/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <link href="https://nwader.sa/croper/cropper.css" rel="stylesheet">
    <script src="https://nwader.sa/croper/cropper.min.js"></script>
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
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">

                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon">
                                                <i class="flaticon-cogwheel"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                 تسجيل المندوب 
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="m-portlet__body">
                                <form action="/add_drivre" id="form" method="post">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @component('components.input',['name'=>'name','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                                    @endcomponent


                                                </div>
                                                <div class="col-md-6">
                                                    @component('components.input',['name'=>'email','text'=>'البريد الالكتروني','placeholder'=>'ادخل البريد الالكتروني','icon'=>'fa-user-alt'])
                                                    @endcomponent

                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col-md-6">
                                                    @component('components.input',['name'=>'password','text'=>'كلمة المرور','placeholder'=>'ادخل كلمة المرور','icon'=>'fa-key'])
                                                    @endcomponent


                                                </div>
                                                <div class="col-md-6">
                                                    @component('components.input',['name'=>'password_confirmation','text'=>'أدخل تأكيد كلمة المرور','placeholder'=>'ادخل تأكيد كلمة المرور','icon'=>'fa-key'])
                                                    @endcomponent

                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col-md-6">

                                                    @component('components.input',['type'=>'number','name'=>'mobile','text'=>'رقم الجوال','placeholder'=>'ادخل رقم الجوال','icon'=>'fa-phone'])
                                                    @endcomponent

                                                </div>
                                                <div class="col">

                                                    @component('components.input',['name'=>'whats_mobile','type'=>'number','text'=>'رقم الواتس آب','placeholder'=>'ادخل رقم الواتس آب','icon'=>'fa-phone'])
                                                    @endcomponent
                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col-md-6">
                                                        @component('components.select',['name'=>'gov_id','text'=>'المدينة','no_def'=>'no_def','select'=>$govs])
                                                        @endcomponent
                                                </div>
                                                <div class="col-md-6">

                                                    @component('components.input',['name'=>'car_type','text'=>'نوع المركبة','placeholder'=>'ادخل نوع المركبة','icon'=>'fa-list'])
                                                    @endcomponent

                                                </div>
{{--                                                <div class="col">--}}
{{--                                                    <div class="form-group m-form__group @has_error('gov_division_id')">--}}
{{--                                                        <label for="gov_division_id">القسم</label>--}}
{{--                                                        <select name="gov_division_id" search="true" id="gov_division_id" data-value="{{old('gov_division_id')}}">--}}
{{--                                                            <option value="">هذا قسم</option>--}}
{{--                                                        </select>--}}
{{--                                                        @show_error('gov_division_id')--}}

{{--                                                    </div>--}}
{{--                                                </div>--}}
                                                <div class="w-100"></div>

                                                <div class="col-md-6">

                                                    @component('components.input',['name'=>'car_number','text'=>'رقم المركبة','placeholder'=>'ادخل رقم المركبة','icon'=>'fa-list'])
                                                    @endcomponent
                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col-md-4">

                                                    @component('components.upload_image',['name'=>'image','text'=>'صورة السائق','hint'=>'100 * 100 بيكسل'])
                                                    @endcomponent

                                                </div>
                                                <div class="col-md-4">

                                                    @component('components.upload_image',['name'=>'license_image','text'=>'رخصة القيادة','hint'=>'400 * 400 بيكسل'])
                                                    @endcomponent
                                                </div>
                                                <div class="col-md-4">

                                                    @component('components.upload_image',['name'=>'identity_image','text'=>'الهوية الشخصية','hint'=>'400 * 400 بيكسل'])
                                                    @endcomponent
                                                </div>
                                                <div class="w-100"></div>
                                            </div>

                                        </div>
                                        <div class="col-md-2">

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                            <i class="fa fa-check"></i>
                                            <span>اضافة</span>
                                        </button>
                                        <a href="{{route('system.drivers.index')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                            <i class="flaticon-cancel"></i>
                                            <span>الغاء</span>
                                        </a>
                                    </div>
                                </form>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <script src="https://nwader.sa/admin/assets/demo/demo3/base/scripts.bundle.js" type="text/javascript"></script>


<script>
    UrlForScripts='https://nwader.sa';
    UrlForAssets='https://nwader.sa';
</script>

<script src="https://nwader.sa/admin/main.js" type="text/javascript"></script>

<script type="text/javascript" src="https://nwader.sa/admin/jquery.nicescroll.min.js" ></script>

<script src="https://nwader.sa/admin/jquery.nice-select.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/sweetalert2.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/jquery-validation/js/localization/messages_ar.min.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/jquery.minicolors.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="https://nwader.sa/admin/datepicker/locales/bootstrap-datepicker.ar.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            $('#form').validate({
                errorElement: 'div', //default input error message container
                errorClass: 'abs_error help-block has-error',
                rules: {
                    price: {
                        required: true,
                        number: true
                    }
                }

            }).init();


        })

    </script>
    <script>
        $(document).ready(function() {
            // loadDivisions($('#gov_id').val());
            //
            // $(document).on('change','#gov_id', function(e) {
            //     var id =   $(this).val();
            //     loadDivisions(id);
            // });
            function loadDivisions(id) {

                if(id != 0){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "get",
                        url: 'https://nwader.sa/get_divisions',
                        data: {id:id},
                        cache: false,
                        success: function(data, textStatus, xhr){
                            if(data.error){
                                swal({
                                    title: 'حدث خطأ ما',
                                    text: 'خطأ مجهول',
                                    type: 'error',
                                    timer: 4000,
                                    showConfirmButton: false
                                })
                            }else{
                                if(xhr.status == 200){
                                    var divisions_api = data.out;
                                    var gov_division_id = $('#gov_division_id');
                                    gov_division_id.empty();
                                    var value =  $('#gov_division_id').attr('data-value');
                                    gov_division_id.append(divisions_api);
                                    gov_division_id.val(value);
                                    gov_division_id.niceSelect('update')
                                }
                            }

                        },

                    });
                }
            }

        });
    </script>

<script>
    $(document).ready(function () {
        $('#clickmewow').click(function () {
            $('#radio1003').attr('checked', 'checked');
        });

        $(function () {
            $('#PageLoader').fadeOut(800);
        })
        $('select:not(.no_nice_select)').niceSelect();
        

        

        


        
        
        
        
        
        
        
        
        
        
        

        
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