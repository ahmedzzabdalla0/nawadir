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
                                    <a class="nav-link m-tabs__link" href="{{route('system.translations.index')}}">
                                        نصوص الاشعارات
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active " href="{{route('system.translations.apiTexts')}}">
                                        نصوص الAPI
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <form action="{{route('system.translations.saveApi')}}" method="post" id="form" >

                                @foreach($translations as $id=>$o)
                                <div class="row justify-content-center align-content-center">
                                    @foreach($o as $local=>$trans)
                                <div class="col-md-5">
                                    @input(['name'=>$id.'_'.$local,'data'=>$trans->value,'text'=>$local=='ar'?'النص بالعربية':'Text in English','placeholder'=>$local,'icon'=>'fa-asterisk'])
                                </div>
                                    @endforeach
                                <div class="col-md-2 row justify-content-center align-content-center">
                                    <div style="margin: 5px;padding: 10px;border:2px solid #ddd;border-radius: 10px;overflow: hidden;width: 100%">
                                        <p class="text-center" style="margin: 0">{{$id}}</p>
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

