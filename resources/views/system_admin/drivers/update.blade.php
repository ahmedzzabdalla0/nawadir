@extends('layouts.admin')

@php
    $Disname='مندوبين التوصيل';
@endphp
@section('title',  $Disname)
@section('head')

@endsection
@section('page_content')


    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{url('/')}}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system_admin.dashboard')}}" class="m-nav__link">
                            <span class="m-nav__link-text">لوحة التحكم</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system.drivers.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">تعديل</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

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
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="m-portlet__body">
                        <form action="{{route('system.drivers.do.update',$out->id)}}" id="form" method="post">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$out->name,'name'=>'name','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                            @endcomponent


                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$out->email,'name'=>'email','text'=>'اسم المستخدم','placeholder'=>'ادخل اسم المستخدم','icon'=>'fa-user-alt'])
                                            @endcomponent

                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6">

                                            @component('components.input',['data'=>$out->mobile,'type'=>'number','name'=>'mobile','text'=>'رقم الجوال','placeholder'=>'ادخل رقم الجوال','icon'=>'fa-phone'])
                                            @endcomponent

                                        </div>
                                        <div class="col">

                                            @component('components.input',['data'=>$out->whats_mobile,'name'=>'whats_mobile','type'=>'number','text'=>'رقم الواتس آب','placeholder'=>'ادخل رقم الواتس آب','icon'=>'fa-phone'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.select',['data'=>$out->gov_id,'name'=>'gov_id','text'=>'المدينة','no_def'=>'no_def','select'=>$govs])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">

                                            @component('components.input',['data'=>$out->car_type,'name'=>'car_type','text'=>'نوع المركبة','placeholder'=>'ادخل نوع المركبة','icon'=>'fa-list'])
                                            @endcomponent

                                        </div>
{{--                                        <div class="col">--}}
{{--                                            <div class="form-group m-form__group @has_error('gov_division_id')">--}}
{{--                                                <label for="gov_division_id">القسم</label>--}}
{{--                                                <select name="gov_division_id" search="true" id="gov_division_id" data-value="{{old('gov_division_id',$out->gov_division_id)}}">--}}
{{--                                                    <option value="">هذا قسم</option>--}}
{{--                                                </select>--}}
{{--                                                @show_error('gov_division_id')--}}

{{--                                            </div>--}}
{{--                                        </div>--}}
                                        <div class="w-100"></div>

                                        <div class="col-md-6">

                                            @component('components.input',['data'=>$out->car_number,'name'=>'car_number','text'=>'رقم المركبة','placeholder'=>'ادخل رقم المركبة','icon'=>'fa-list'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'password','text'=>'كلمة المرور','placeholder'=>'ادخل كلمة المرور','icon'=>'fa-key','not_req'=>'fa-key'])
                                            @endcomponent


                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'password_confirmation','text'=>'أدخل تأكيد كلمة المرور','placeholder'=>'ادخل تأكيد كلمة المرور','icon'=>'fa-key','not_req'=>'fa-key'])
                                            @endcomponent

                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-4">

                                            @component('components.upload_image',['data'=>$out->avatar,'name'=>'image','text'=>'صورة السائق','hint'=>'100 * 100 بيكسل'])
                                            @endcomponent

                                        </div>
                                        <div class="col-md-4">

                                            @component('components.upload_image',['data'=>$out->license,'name'=>'license_image','text'=>'رخصة القيادة','hint'=>'400 * 400 بيكسل'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-4">

                                            @component('components.upload_image',['data'=>$out->identity,'name'=>'identity_image','text'=>'الهوية الشخصية','hint'=>'400 * 400 بيكسل'])
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
                                    <span>تعديل</span>
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

@endsection





@section('custom_scripts')
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
                        url: '{{ route('system.areas.get_divisions') }}',
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
@endsection


