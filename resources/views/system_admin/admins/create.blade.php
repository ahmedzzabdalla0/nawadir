@extends('layouts.admin')

@php
    $Disname='الادارة';
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
                        <a href="{{route('system.admin.index')}}" class="m-nav__link">
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
                                <form action="{{route('system.admin.do.create')}}" id="form" method="post">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-10">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    @component('components.input',['name'=>'name','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                                    @endcomponent


                                                </div>
                                                <div class="col-md-6">
                                                    @component('components.input',['name'=>'username','text'=>'اسم المستخدم','placeholder'=>'ادخل اسم المستخدم','icon'=>'fa-user-alt'])
                                                    @endcomponent

                                                </div>
                                                <div class="w-100"></div>
                                                <div class="col-md-6">

                                                    @component('components.input',['name'=>'mobile','text'=>'رقم الجوال','placeholder'=>'ادخل رقم الجوال','icon'=>'fa-phone'])
                                                    @endcomponent

                                                </div>
                                                <div class="col">

                                                    @component('components.input',['name'=>'password','type'=>'password','text'=>'كلمة المرور','placeholder'=>'ادخل كلمة المرور','icon'=>'fa-lock'])
                                                    @endcomponent
                                                </div>
                                                <div class="w-100"></div>
                                            </div>

                                        </div>
                                        <div class="col-md-2">
                                            @component('components.upload_image',['name'=>'image','text'=>'صورة الحساب','hint'=>'100 * 100 بيكسل'])
                                            @endcomponent
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                            <i class="fa fa-check"></i>
                                            <span>اضافة</span>
                                        </button>
                                        <a href="{{route('system.admin.index')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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

@endsection


