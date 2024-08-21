@extends('layouts.admin')

@php

    $Disname='الخدمات';

@endphp

@section('title',  $Disname)


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
                        <a href="{{route('system.services.index')}}" class="m-nav__link">
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

                        <!-- BEGIN FORM-->

                        <form action="{{route('system.services.do.create')}}" id="form" method="post"

                              class="form-horizontal">

                            @csrf

                            <div class="row justify-content-center">

                                <div class="col-md-3">
                                    @component('components.upload_image',['name'=>'uploaded_image_name','text'=>'صورة الخدمة','hint'=>'400 * 400 بيكسل'])
                                    @endcomponent
                                </div>

                                <div class="w-100"></div>
                                <div class="col-md-6">

                                    @component('components.input',['name'=>'name','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                                <div class="w-100"></div>

                                <div class="col-md-6">
                                    @component('components.area',['name'=>'details','text'=>'التفاصيل'])
                                    @endcomponent
                                </div>

                            </div>


                            <div class="row  justify-content-center">
                                <button type="submit" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>اضافة</span>
                                </button>
                                <a href="{{route('system.services.index')}}" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                    <i class="flaticon-cancel"></i>
                                    <span>الغاء</span>
                                </a>
                            </div>

                        </form>

                        <!-- END FORM-->

                    </div> </div>
            </div>

        </div>

    </div>




    <!-- END PAGE BASE CONTENT -->

@endsection


@section('custom_scripts')



    <script>

        $(function () {

            $('#form').validate({

                errorElement: 'div', //default input error message container

                errorClass: 'abs_error help-block has-error',


            }).init();

        })



    </script>



@endsection





