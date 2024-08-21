@extends('layouts.admin')
@php
    $Disname='التقارير';
    $icon='fas fa-clipboard-check';
@endphp
@section('title', $Disname)

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
                                                <i class="{{$icon}}"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body  m-portlet__body--no-padding">
                        <div class="row m-row--no-padding m-row--col-separator-xl">
                            <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                                <a href="{{route('system.reports.r5')}}" style="text-decoration: none;">

                                    <div class="card-box bg-blue">
                                        <div class="icon">
                                            <i class="fas fa-xs fa-user-tag" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$users}}</h3>
                                            <h4>العملاء</h4>
                                        </div>
                                        <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                                <a href="{{route('system.reports.r1')}}">
                                    <div class="card-box m--bg-accent">
                                        <div class="icon">
                                            <i class="  fas fa-xs fa-shopping-cart" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$orders}}</h3>
                                            <h4>الطلبات</h4>
                                        </div>
                                        <div class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                                    </div>

                                </a>

                            </div>


                            <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                                <a href="{{route('system.reports.r3')}}">
                                    <div class="card-box bg-danger">
                                        <div class="icon">
                                            <i class="fas fa-xs fa-shopping-basket" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$products}}</h3>
                                            <h4>المنتجات</h4>
                                        </div>
                                        <div class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                                    </div>
                                </a>

                            </div>



                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('custom_scripts')
    <script>
        $(function () {
            $('.input-daterange').datepicker({
                rtl: true,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
        })
    </script>

@endsection
