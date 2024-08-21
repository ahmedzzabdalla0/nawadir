@extends('layouts.admin')

@php
    $Disname='المدن و الأحياء';

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
                        <a href="{{route('system.areas.index')}}" class="m-nav__link">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </span>
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

                <div class="m-portlet">

                    <div class="m-portlet__head">

                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <i class="fas fa-lg fa-globe"></i>

                                <span class="m-portlet__head-ico">{{$Disname}}</span>

                            </div></div>

                    </div>

                            <div class="m-portlet__body">

                                <!-- BEGIN FORM-->

                                <form action="{{route('system.govs.do.update',$out->id)}}" id="form" method="post"

                                      class="form-horizontal">

                                    @csrf

                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="row">

                                                <div class="col col-md-6">
                                                    <div class="form-group m-form__group @has_error('name_ar')">
                                                        <label for="name">الإسم </label>
                                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                            <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="الإسم"
                                                                   required name="name_ar" value="@old('name_ar',$out->name)" id="name">

                                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-file"></i></span></span>
                                                        </div>
                                                        @show_error('name_ar')

                                                    </div>
                                                </div>


                                                <div class="col col-md-6">
                                                    <div class="form-group m-form__group @has_error('name_en')">
                                                        <label for="name">الإسم بالانجليزية</label>
                                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                            <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder=" الإسم بالانجليزية"
                                                                   required name="name_en" value="@old('name_en',$out->name_en)" id="name">

                                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-file"></i></span></span>
                                                        </div>
                                                        @show_error('name_en')

                                                    </div>
                                                </div>

                                        </div>

                                        <div class="clearfix"></div>

                                    </div>
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col">
                                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                            <i class="fa fa-check"></i>
                                            <span>اضافة</span>
                                        </button>
                                        <a href="{{route('system.areas.index')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                            <i class="flaticon-cancel"></i>
                                            <span>الغاء</span>
                                        </a>
                                    </div>





                                </form>

                                <!-- END FORM-->

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>
    </div>



    <!-- END PAGE BASE CONTENT -->

@endsection





@section('plugins')

    <script src="{{asset('js/sweetalert2.js')}}" type="text/javascript"></script>





    <script src="{{asset('metronic/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}"

            type="text/javascript"></script>

    <link rel="stylesheet" href="{{asset('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5-rtl.css')}}">

    <script src="{{asset('metronic/global/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js')}}"

            type="text/javascript"></script>

    <script src="{{asset('metronic/global/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js')}}"

            type="text/javascript"></script>

    <script src="{{asset('metronic/global/plugins/bootstrap-wysihtml5/locales/bootstrap-wysihtml5.ar-AR.js')}}"

            type="text/javascript"></script>

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





