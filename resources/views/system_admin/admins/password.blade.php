@extends('layouts.admin')

@php
    $Disname='المدراء';
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
                    </li>  <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system.admin.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">استعادة كلمة المرور</span>
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

                        <form action="{{route('system.admin.do.password',$out->id)}}" id="form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group m-form__group @has_error('password')">
                                        <label for="password">كلمة المرور الجديدة </label>
                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                            <input type="password" class="form-control m-input m-input--pill m-input--air" placeholder="كلمة المرور"
                                                   required name="password" value="@old('password')" id="password">
                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-lock"></i></span></span>
                                        </div>
                                        @show_error('password')

                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group m-form__group @has_error('password_confirmation')">
                                        <label for="password_confirmation">تأكيد كلمة المرور الجديدة </label>
                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                            <input type="password" class="form-control m-input m-input--pill m-input--air" placeholder="كلمة المرور"
                                                   required name="password_confirmation" value="@old('password_confirmation')" id="password_confirmation">
                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-lock"></i></span></span>
                                        </div>
                                        @show_error('password_confirmation')

                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col">
                                    <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-check"></i>
                                        <span>تغيير</span>
                                    </button>
                                    <a href="{{route('system.admin.index')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                        <i class="flaticon-cancel"></i>
                                        <span>الغاء</span>
                                    </a>
                                </div>
                            </div>



                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
