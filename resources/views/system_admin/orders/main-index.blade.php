@extends('layouts.admin')
@php
    $Disname='الطلبات';
    $icon='fas fa-shopping-cart';
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
                            @cando('view','orders')
                            <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                                <a href="{{route('system.orders.index')}}">
                                    <!--begin::new orders-->
                                    <div class="m-widget24">
                                        <div class="m-widget24__item">
                                            <h4 class="m-widget24__title" style="font-size: 1.5rem;">
                                                الطلبات الجديدة
                                            </h4><br>
                                            <span class="m-widget24__desc">
													 الطلبات الجديدة
												</span>
                                            <span class="m-widget24__stats m--font-brand" id="new_orders_counter">
													{{$orders}}
												</span>
                                            <div class="m--space-10"></div>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar m--bg-brand" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="m-widget24__change">
													<span>عرض المزيد</span>
												</span>
                                            <span class="m-widget24__number">
													<i class="fa fa-arrow-left"></i>
												</span>

                                        </div>
                                    </div>

                                    <!--end::new orders-->
                                </a>

                            </div>

                            <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">
                                <a href="{{route('system.orders.archive')}}">
                                <!--begin::kitchens orders-->
                                <div class="m-widget24">
                                    <div class="m-widget24__item">
                                        <h4 class="m-widget24__title" style="font-size: 1.5rem;">
                                            أرشيف الطلبات
                                        </h4><br>
                                        <span class="m-widget24__desc">
													أرشيف الطلبات
												</span>
                                        <span class="m-widget24__stats m--font-brand">
													{{$archived}}
												</span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-info" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="m-widget24__change">
													<span>عرض المزيد</span>
												</span>
                                        <span class="m-widget24__number">
													<i class="fa fa-arrow-left"></i>
												</span>
                                    </div>
                                </div>

                                <!--end::kitchens orders-->
                                </a>
                            </div>


                            <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">
                                <a href="{{route('system.orders.canceled')}}">
                                <!--begin::driver orders-->
                                <div class="m-widget24">
                                    <div class="m-widget24__item">
                                        <h4 class="m-widget24__title" style="font-size: 1.5rem;">
                                            الطلبات الملغية
                                        </h4><br>
                                        <span class="m-widget24__desc">
													الطلبات الملغية
												</span>
                                        <span class="m-widget24__stats m--font-brand">
													{{$canceled}}
												</span>
                                        <div class="m--space-10"></div>
                                        <div class="progress m-progress--sm">
                                            <div class="progress-bar m--bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <span class="m-widget24__change">
													<span>عرض المزيد</span>
												</span>
                                        <span class="m-widget24__number">
													<i class="fa fa-arrow-left"></i>
												</span>
                                    </div>
                                </div>

                                <!--end::driver orders-->
                                </a>
                            </div>
                            @endcando

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
