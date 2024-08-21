@extends('layouts.admin')
@php
    $Disname='الدول';
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
                        <a href="{{route('system_admin.generalProperties')}}" class="m-nav__link">
                            <span class="m-nav__link-text">الخصائص العامة</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{route('system.countries.index')}}" class="m-nav__link">
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
                        <form action="{{route('system.countries.do.update',$out->id)}}" id="form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('ar_title')">
                                                <label for="name">اسم الدولة بالعربي </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="الاسم بالعربية"
                                                           required name="name_ar" value="@old('name_ar',$out->name_ar)" id="name_ar">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-user-alt"></i></span></span>
                                                </div>
                                                @show_error('name_ar')
                                            </div>

                                        </div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('en_title`')">
                                                <label for="username">اسم الدولة بالانجليزي</label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="الاسم بالانجليزيه"
                                                           required name="name_en" value="@old('name_en',$out->name_en)" id="name_en">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-user-alt"></i></span></span>
                                                </div>
                                                @show_error('name_en')
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('ar_title')">
                                                <label for="name">مفتاح الدولة</label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="مفتاح الدولة"
                                                           required name="prefix" value="@old('prefix',$out->prefix)" id="prefix">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-user-alt"></i></span></span>
                                                </div>
                                                @show_error('prefix')
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('mobile_digits')">
                                                <label for="mobile_digits">عدد خانات الجوال غير شامل مفتاح الدولة</label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="عدد الخانات"
                                                           required name="mobile_digits" value="@old('mobile_digits',$out->mobile_digits)" id="mobile_digits">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-phone"></i></span></span>
                                                </div>
                                                @show_error('mobile_digits')
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('currency_ar')">
                                                <label for="name">اسم العملة </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="اسم العملة بالعربية"
                                                           required name="currency_ar" value="@old('currency_ar',$out->currency_ar)" id="currency_ar">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-dollar-sign"></i></span></span>
                                                </div>
                                                @show_error('currency_ar')
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('currency_en')">
                                                <label for="username">اسم العملة </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="اسم العملة بالانجليزية"
                                                           required name="currency_en" value="@old('currency_en',$out->currency_en)" id="currency_en">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-percentage"></i></span></span>
                                                </div>
                                                @show_error('currency_en')
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="w-100"></div>

                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('tax')">
                                                <label for="username">الضريبة</label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="الضريبة"
                                                           required name="tax" value="@old('tax',$out->tax)" id="tax">
                                                    <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-percentage"></i></span></span>
                                                </div>
                                                @show_error('tax')
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h5 style="text-align: center">ايقونة العلم</h5>
                                    <div class="imageContainer">
                                        <label for="MYimage" class="imgy" style="/*width: 100%;*/cursor: pointer;">
                                            <img src="<?= old('uploaded_image_name',$out->flag) ? url('uploads/' . old('uploaded_image_name',$out->flag)) : url('avatar.png') ?>"
                                                 style="width: 100%;" class="MyImagePrivew thumbnail"
                                                 alt="">
                                        </label>
                                        <input type="file" id="MYimage" style="display: none"
                                               name="flag"
                                               class="upload_image">
                                        <input type="hidden" value="<?= old('uploaded_image_name',$out->flag) ?>"
                                               name="uploaded_image_name" class="uploaded_image_name">
                                        <div class="image-loader"></div>
                                    </div>
                                    @show_error('uploaded_image_name')
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>تعديل</span>
                                </button>
                                <a href="{{route('system.countries.index')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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

