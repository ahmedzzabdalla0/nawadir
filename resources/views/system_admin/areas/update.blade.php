@extends('layouts.admin')

@php

    $Disname='المدن و الأحياء';

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
                        <a href="{{route('system_admin.generalProperties')}}" class="m-nav__link">
                            <span class="m-nav__link-text">الخصائص العامة</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system.areas.index')}}" class="m-nav__link">
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

                        <form action="{{route('system.areas.do.update',$out->id)}}" id="form" method="post"
                              class="form-horizontal">
                            <input type="hidden" name="type" value="1">
                            @csrf

                            <div class="row justify-content-center">

                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    @component('components.input',['data'=>$out->name,'name'=>'name_ar','text'=>'الاسم','placeholder'=>'ادخل الاسم','$no_def'=>'fa-user-alt'])
                                    @endcomponent

                                </div>
                                <div class="w-100" ></div>

                                <div class="col-md-6" >
                                    @component('components.input',['name'=>'name_en','data'=>$out->name_en,'text'=>'name','placeholder'=>'Enter the name','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                            </div>


                            <div class="row  justify-content-center">
                                <button type="submit" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>تعديل</span>
                                </button>
                                <a href="{{route('system.areas.index')}}" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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





