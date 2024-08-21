@extends('layouts.admin')

@php
    $Disname='الاشعارات';
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
                        <a href="{{route('system.notifications.index')}}" class="m-nav__link">
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
                                                <i class="fa fa-bell"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="m-portlet__body">
                        <form action="{{route('system.notifications.do.send_per_user')}}" id="form" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$id}}">
                            <input type="hidden" name="redirect_to" value="{{$redirect}}">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="row justify-content-center">
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('title')">
                                                <label for="title">العنوان</label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder="العنوان"
                                                           required name="title" value="@old('title')" id="title">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('title')

                                            </div>


                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('message')">
                                                <label for="message">نص الاشعار </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder="نص الاشعار"
                                                           required name="message" value="@old('message')" id="message">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('message')

                                            </div>


                                        </div>
                                    </div>

                                </div>

                                <div class="clearfix"></div>
                            </div>
                            <div class="col row justify-content-center">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>اضافة</span>
                                </button>
                                <a href="{{route($redirect,['id'=>$id])}}" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom">
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


        });
    </script>

@endsection


