@extends('layouts.admin')

@php

    $Disname='كوبونات الخصم';
    $icon='fas fa-ticket-alt';

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
                        <a href="{{route('system.coupons.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">اضافة كوبون خصم</span>
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
                                                <i class="{{$icon}}"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                    </div>


                    <div class="m-portlet__body">

                        <!-- BEGIN FORM-->

                        <form action="{{route('system.coupons.do.create')}}" id="form" method="post"

                              class="form-horizontal">

                            @csrf
                            <div class="row">
                                <div class="col-md-7" style="margin: auto">
                                    <div class="col">
                                        @component('components.input',['maxlength'=>120,'name'=>'coupon_code','text'=>'كود الخصم','placeholder'=>'كود الخصم','icon'=>'fa-tag'])
                                        @endcomponent
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="form-group m-form__group @has_error('start_date') @has_error('end_date')">
                                            <label for="start_date"> حدد تاريخ بداية و نهاية الكوبون </label>
                                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                <div id="select_dates" class="input-group input-daterange">
                                                    <input type="text" readonly name="start_date"
                                                           value="{{ old('start_date') }}"
                                                           class="form-control m-input m-input--pill"
                                                           placeholder="من تاريخ">
                                                    <button type="button" class="reset_field"><i
                                                                class="fa fa-times"></i></button>
                                                    <input type="text" readonly name="end_date"
                                                           value="{{ old('end_date') }}"
                                                           class="form-control m-input m-input--pill"
                                                           placeholder="الى تاريخ">
                                                </div>
                                            </div>
                                            @show_error('start_date')
                                            <br>
                                            @show_error('end_date')
                                        </div>

                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        @component('components.input',['maxlength'=>3,'type'=>'number','name'=>'discount','text'=>'نسبة الخصم','placeholder'=>'نسبة الخصم','icon'=>'fa-percent'])
                                        @endcomponent
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        @component('components.input',['maxlength'=>10,'type'=>'number','name'=>'valid_count','text'=>'عدد مرات الاستخدام المسموحة','placeholder'=>'عدد مرات الاستخدام المسموحة','icon'=>'fa-users'])
                                        @endcomponent
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="form-group m-form__group @has_error('send_user_notification')">
                                            <div class="row" style="margin-top: 25px;">
                                                <label class="col-6 col-form-label" for="send_user_notification">ارسال اشعار للمستخدمين بكوبون الخصم؟</label>
                                                <div class="col-6" style="text-align: left;">
                                                    <span class="m-switch m-switch--icon">
                                                        <label>
                                                            <input type="checkbox" id="send_user_notification" name="send_user_notification"
                                                                   value="1" {{old('send_user_notification')==1?'checked="checked"':''}}>
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                </div>
                                                <div class="col-12" style="text-align: center">
                                                    @show_error('send_user_notification')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100 notification_input"></div>
                                    <div class="col notification_input">
                                        @component('components.input',['name'=>'title','text'=>'عنوان الاشعار','placeholder'=>'عنوان الاشعار','icon'=>'fa-users'])
                                        @endcomponent
                                    </div>
                                    <div class="w-100 notification_input"></div>
                                    <div class="col notification_input">
                                        @component('components.input',['name'=>'message','text'=>'نص الاشعار','placeholder'=>'نص الاشعار','icon'=>'fa-users'])
                                        @endcomponent
                                    </div>
                                </div>

                            </div>


                            <div class="row">
                                <button type="submit" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>اضافة</span>
                                </button>
                                <a href="{{route('system.coupons.index')}}" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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

<script>
    $(document).ready(
        function(){
            if($('#send_user_notification').is(':checked')){
                $('div.notification_input').css('display','block');
            }else{
                $('div.notification_input').css('display','none');
            }
            $('#send_user_notification').on('change',function () {
                if($('#send_user_notification').is(':checked')){
                    $('div.notification_input').css('display','block');
                }else{
                    $('div.notification_input').css('display','none');
                }
            });
        }
    );
</script>

@endsection





