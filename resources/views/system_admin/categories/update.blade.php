@extends('layouts.admin')

@php

    $Disname='التصنيفات';

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
                        <a href="{{route('system.categories.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
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

                        <form action="{{route('system.categories.do.update',$out->id)}}" id="form" method="post"

                              class="form-horizontal">

                            @csrf

                            <div class="row justify-content-center">
                                <div class="col-md-3">
                                    @component('components.upload_image',['data'=>$out->logo,'name'=>'image','text'=>'صورة التصنيف','hint'=>'60 * 60 بيكسل'])
                                    @endcomponent
                                </div>

                                <div class="w-100"></div>
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    @component('components.input',['data'=>$out->name_ar,'name'=>'name_ar','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                    @endcomponent

                                </div>
                                <div class="w-100"></div>

                                <div class="col-md-6" >
                                    @component('components.input',['name'=>'name_en','data'=>$out->name_en,'text'=>'name','placeholder'=>'Enter the name','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                            </div>
           
                                                   <div class="col">
                                            <div class="form-group m-form__group @has_error('status')">
                                                <label for="status"> تعطيل    </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="checkbox"  class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder=" "
                                                    @if($out->status == "0") checked @else echo "" @endif
                                                            name="status" value="{{$out->status}}" id="status">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('status')

                                            </div>


                                        </div>

                            <div class="row  justify-content-center">
                                <button type="submit" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>تعديل</span>
                                </button>
                                <a href="{{route('system.categories.index')}}" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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





