@extends('layouts.admin')
@php
    $Disname='التقارير';
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



    <!-- END: Subheader -->
    <div class="m-content">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h2 style="text-align: center;color: #3e3e3e;margin-bottom: 40px;">الرجاء اختيار تصنيف التقارير</h2>

            </div>
            <div class="w-100"></div>
{{--            <div class="col-md-12 col-lg-6 col-xl-3">--}}
{{--                <a href="{{route('system.reports.r1')}}">--}}
{{--                    <div class="myWidget">--}}
{{--                        <i class="fas fa-magic"></i>--}}
{{--                        <h4>--}}
{{--                            تقارير الكوافيرات--}}
{{--                        </h4>--}}
{{--                    </div>--}}
{{--                </a>--}}
{{--            </div>--}}
            <div class="col-md-12 col-lg-6 col-xl-3">
                <a href="{{route('system.reports.r1')}}">
                    <div class="myWidget">
                        <i class="fas fa-shopping-cart"></i>
                        <h4>
                            تقارير الطلبات
                        </h4>
                    </div>
                </a>

            </div>

            <div class="col-md-12 col-lg-6 col-xl-3">
                <a href="{{route('system.reports.r3')}}">
                    <div class="myWidget">
                        <i class="fas fa-hockey-puck"></i>
                        <h4>
                            تقارير المنتجات
                        </h4>
                    </div>
                </a>
            </div>

        </div>
    </div>
@endsection

