@extends('layouts.admin')

@php
    $Disname='الفعاليات';
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
                        <a href="{{route('system.activities.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">اضافة</span>
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
                        <form action="{{route('system.activities.do.update',$out->id)}}" id="form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$out->name,'name'=>'name','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$out->address,'name'=>'address','text'=>'العنوان','placeholder'=>'ادخل عنوان الفعالية','icon'=>'fa-map'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>

                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$out->start_date,'name'=>'start_date','type'=>'date','text'=>'تاريخ البداية','icon'=>'fa-clock'])
                                            @endcomponent

                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$out->days,'name'=>'days','type'=>'number','text'=>'مدة المعرض بالايام','icon'=>'fa-clock'])
                                            @endcomponent

                                        </div>
                                        <div class="w-100"></div>

                                            <div class="col-md-12">
                                                @component('components.area',['data'=>$out->description,'name'=>'description','text'=>'التفاصيل مختصر','placeholder'=>'100 حرف على اكثر تقدير','rows'=>2])
                                                @endcomponent

                                            </div>
                                            <div class="col-md-12">
                                                @component('components.area',['data'=>$out->details,'name'=>'details','text'=>'التفاصيل','rows'=>10])
                                                @endcomponent

                                            </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">

                                        <div class="col-md-12">
                                            @component('components.multiupload_update',['name'=>'multi_images','name1'=>'def_image','text'=>'الصور ','add_route'=>'system.activities.upload_image','path'=>'system_admin.test_with_multi_upload.images','defimage'=>$out->image,'out'=>$out])
                                            @endcomponent

                                        </div>

                                    </div>

                                </div>

                            </div>


                            <div class="clearfix"></div>
                            <div class="col">
                                <button type="submit"
                                        class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>تعديل</span>
                                </button>
                                <a href="{{route('system.activities.index')}}"
                                   class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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
            $('#is_participation').on('click', function () {
                if ($(this).is(':checked')) {
                    $('.part_ratio').hide();
                } else {
                    $('.part_ratio').show();
                }
            });

        })

    </script>

@endsection


