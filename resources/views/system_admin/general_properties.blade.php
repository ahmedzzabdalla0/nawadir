@extends('layouts.admin')
@php
    $Disname='الخصائص العامة';
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

                            @cando('view','categories')

                            <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                                <a href="{{route('system.categories.index')}}">
                                    <div class="card-box bg-success">
                                        <div class="icon">
                                            <i class="fa fa-xs fa-list" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$categories}}</h3>
                                            <h4>التصنيفات</h4>
                                        </div>
                                        <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                                    </div>
                                </a>

                            </div>
                            @endcando
                            @cando('view','cut_types')

                            <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                                <a href="{{route('system.cut_types.index')}}">
                                    <div class="card-box m--bg-accent">
                                        <div class="icon">
                                            <i class="fa fa-xs fa-list" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$cut_types}}</h3>
                                            <h4>أنواع التقطيع</h4>
                                        </div>
                                        <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                                    </div>
                                </a>

                            </div>
                            @endcando
                            @cando('view','areas')

                            <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                                <a href="{{route('system.areas.index')}}">
                                    <div class="card-box bg-info">
                                        <div class="icon">
                                            <i class="fas fa-xs fa-globe" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$areas}}</h3>
                                            <h4>المدن و الأحياء</h4>
                                        </div>
                                        <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-{{app()->getLocale() =='en'?'right':'left'}}"></i></div>
                                    </div>
                                </a>

                            </div>
                            @endcando
                            @if($config['product_properties']==1)
                            @cando('view','sizes')

                            <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                                <a href="{{route('system.sizes.index')}}">
                                    <div class="card-box bg-warning">
                                        <div class="icon">
                                            <i class="fas fa-xs fa-shapes" aria-hidden="true"></i>
                                        </div>
                                        <div class="inner">
                                            <h3>{{$sizes}}</h3>
                                            <h4>أحجام الحاشي</h4>
                                        </div>
                                        <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-{{app()->getLocale() =='en'?'right':'left'}}"></i></div>
                                    </div>
                                </a>

                            </div>
                            @endcando
                            @endif
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
