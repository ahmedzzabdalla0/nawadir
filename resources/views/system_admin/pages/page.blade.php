@extends('layouts.admin')

@php
    $Disname='الصفحات';
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
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
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
                        <form action="{{route('system.pages.do.update',$page->id)}}" method="post" id="form">
                            @csrf


                            <div class="row">
                                <div class="col-md-12">
                                    @component('components.input',['data'=>$page->title_ar,'name'=>'title_ar','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                                <div class="col-md-6" style="display: none">
                                    @component('components.input',['data'=>$page->title_en,'name'=>'title_en','text'=>'name','placeholder'=>'Enter the name','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">

                                    @component('components.area_editor',['data'=>$page->text_ar,'name'=>'text_ar','text'=>'التفاصيل '])
                                    @endcomponent

                                </div>
                                <div class="col-md-12" style="display: none">

                                    @component('components.area_editor',['data'=>$page->text_en,'name'=>'text_en','text'=>'details '])
                                    @endcomponent

                                </div>

                            </div>


                            <div class="clearfix"></div>
                            <div class="col">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>حفظ</span>
                                </button>
                                <a href="{{route('system.pages.index')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                    <i class="flaticon-cancel"></i>
                                    <span>الغاء</span>
                                </a>
                            </div>


                            <div class="clearfix">
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
        $(document).ready(function () {
            var form3 = $('#form');
            form3.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error'
            }).init();


        });
    </script>
@endsection
