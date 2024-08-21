@extends('layouts.admin')

@php
    $Disname='الصفحات';
@endphp
@section('title',  $Disname)
@section('head')

    <style>
        .page , .title {
            padding-top: 1.43rem;
            font-weight: 600;
            text-align: center;
        }
    </style>
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
                        <h4>الرجاء اختيار الصفحة</h4>
                        <div class="row">
                            <?php foreach($pages as $p){ ?>
                                <div class="col-md-12 col-lg-6 col-xl-3">

                                    <!--begin::New Users-->
                                    <div class="m-widget24" style="background: #eaeaea;padding: 20px;">
                                        <div class="m-widget24__item">

                                            <h4 class="page">
													 صفحة
												</h4>
                                            <h5 class="title">
                                                <?=$p->title?>
                                            </h5>

                                            <div class="clearfix"></div>

                                            <a class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom btn-block"  href="{{route('system.pages.update',$p->id)}}">تعديل الصفحة<i
                                                        class="m-icon-swapleft m-icon-white"></i>
												</a>

                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>

                        <div class="clearfix"></div>

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
