@extends('layouts.admin')

@php
    $Disname='النصوص';
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
                <div class="m-portlet  m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon">
                                                <i class="fa fa-language"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--right m-tabs-line-danger"
                                role="tablist">
                                <li class="nav-item m-tabs__item ">
                                    <a class="nav-link m-tabs__link active " href="{{route('system.translations.index')}}">
                                        نصوص الاشعارات
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" href="{{route('system.translations.apiTexts')}}">
                                        نصوص الAPI
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <form action="{{route('system.translations.saveText')}}" method="post" id="form" >

                                @foreach($out as $o)
                                <div class="row row justify-content-center align-content-center">
                                <div class="col-md-5">
                                    @input(['name'=>$o->notification_key.'_title_ar','data'=>$o->title_ar,'text'=>'العنوان','placeholder'=>'ادخل العنوان','icon'=>'fa-edit'])
                                    @area(['rows'=>2,'name'=>$o->notification_key.'_message_ar','data'=>$o->message_ar,'text'=>'النص','placeholder'=>'ادخل النص','icon'=>'fa-edit'])
                                </div>
                                <div class="col-md-5">
                                    @input(['name'=>$o->notification_key.'_title_en','data'=>$o->title_en,'text'=>'Title','placeholder'=>'Enter Title','icon'=>'fa-edit'])
                                    @area(['rows'=>2,'name'=>$o->notification_key.'_message_en','data'=>$o->message_en,'text'=>'Message','placeholder'=>'Enter Message','icon'=>'fa-edit'])
                                </div>
                                <div class="col-md-2 row justify-content-center align-content-center">
                                    <div style="margin: 5px;padding: 10px;border:2px solid #ddd;border-radius: 10px;overflow: hidden;width: 100%">
                                        <p class="text-center" style="margin: 0">{{$o->notification_key}}</p>
                                        <hr style="margin: 3px">
                                        <p class="text-center" style="margin: 0">البيانات مع الاشعار</p>
                                        <hr style="margin: 3px">
                                        @if($o->data_to_send)
                                        @foreach($o->data_to_send as $d)
                                            <p class="text-center" style="margin: 0">{{$d}}</p>
                                        @endforeach
                                            @else
                                            {{'-'}}
                                        @endif
                                    </div>

                                </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                </div>
                                @endforeach

                            @csrf

                            <div class="clearfix"></div>
                            <br>

                            <div class="col">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>تعديل</span>
                                </button>
                                <a href="{{route('system_admin.dashboard')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                    <i class="flaticon-cancel"></i>
                                    <span>الغاء</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

