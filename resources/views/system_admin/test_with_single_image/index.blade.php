@extends('layouts.admin')
@php
    $Disname='الخدمات';
    $icon='fab fa-buffer';
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
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                @cando('add','services')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.services.create')}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة</span>
                                    </a>
                                </li>
                                @endcando

                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">

                        @if(isset($out) && count($out) > 0)

                                    @foreach($out as $o)

                                <div class="productItem">

                                    @cando('delete','services')
                                    <button class="btn-del delaps"
                                            data-id="{{ $o->id }}"
                                            data-aaa="tooltip"
                                            data-url="{{route('system.services.delete')}}"
                                            data-token="{{csrf_token()}}"
                                            title="حذف"><i class="fa fa-trash"></i>
                                    </button>
                                    @endcando

                                    @cando('edit','services')
                                    <a href="{{route('system.services.update',$o->id)}}"
                                       class="editaps" data-aaa="tooltip"
                                       title="تعديل">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @endcando

                                    <div class="img">
                                        <img src="<?= url('uploads/' . $o->image) ?>"alt="">

                                    </div>
                                    <p><?= $o->title ?></p>
                                </div>

                                    @endforeach

                        <div class="clearfix"></div>
                            {!! $out->links() !!}
                        @else
                            <div class="note note-info">
                                <h4 class="block">لا يوجد بيانات للعرض</h4>
                            </div>
                        @endif

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('custom_scripts')

    <style>


        .delaps{
            position: absolute;
            top: 0;
            left: 0;
            color: red;
            border: 0;
            background: #ded8d4;
            font-size: 18px;
            z-index: 3;
            padding: 0px 10px 5px 5px;
            border-radius: 0 0 20px 0 !important;
            cursor: pointer;
        }
        .editaps{
            position: absolute;
            top: 0;
            right: 0;
            padding: 0px 5px 5px 10px;
            border-radius: 0 0 0 20px !important;
            color: #a98fde;
            border: 0;
            background: #d2d6de;
            font-size: 18px;
            cursor: pointer;
            z-index: 3;
        }

        .productItem{
            width: 15%;
            height: 220px;
            background: #fff;
            box-shadow: 0px 0px 10px 0px #a190c3;
            position: relative;
            display: block;
            float: right;
            margin: 10px 0.8%;
            border: 2px solid #e0e0e0;
            overflow: hidden;
        }
        .productItem .img{
            width: 100%;
            height: 150px;
            border-radius: 0 0 10px 10px !important;

        }
        .productItem img{
            margin: auto;
            top: 15px;
            position: relative;
            display: block;
            border-radius: 0 0 10px 10px !important;
            height: 140px;
        }
        .productItem p{
            padding: 9px;
            margin: 0;
            text-align: center;
            font-size: 16px;
            color: #423f3f;
            font-weight: 600;
        }
    </style>

@endsection


