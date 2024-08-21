@extends('layouts.admin')
@php
    $Disname='الطلبات الجديدة';
    $icon=' fas fa-shopping-cart';

@endphp
@section('title', $Disname)

@section('head')
    <style>
        .orders_new_content{
            text-align: center;
            border: 1px solid #eee;
            border-radius: 5px;
            overflow: hidden;
            margin-top: 20px;
            width: 100%;
            font-size: 14px!important;
            /*min-width: 300px;*/
        }
        .status_title{
            padding: 12px;
            border-bottom: 4px solid #eee;
            background:#387807;
            color:#fff;
        }
        .order_item{
            border: 2px solid #eee;
            margin: 10px;
            /*border-radius: 10px;*/
            display: flex;
            justify-content: center;
            align-items: stretch;
            flex-wrap: wrap;
        }
        .rightCont{
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            padding: 5px;
            width: 60px;
            border: 1px solid #eee;
            border-radius: 0 0 10px 10px;
            -ms-flex-line-pack: center !important;
            align-content: center !important;
            -webkit-box-pack: center !important;
            -ms-flex-pack: center !important;
            justify-content: center !important;
        }
        .centerCont{
            /*padding: 10px;*/
            width: calc(100% - 60px);
        }
        .centerCont .details{
            text-align: right;
        }
        .centerCont .details p{
            padding: 0;
            margin: 0;
        }
        .leftCont{
            padding: 10px;
            width: 100px;
            border: 1px solid #eee;
            border-radius: 0 0 10px 10px;
        }
        .titleCont{
            padding: 10px;
            width: 100%;
            border-bottom: 2px solid #eee;
            /*display: flex;*/
            /*justify-content: center;*/
            /*align-items: center;*/
            /*flex-wrap: wrap;*/
        }
        /*.right{*/
        /*    text-align: right;*/
        /*    width: 40%;*/
        /*}*/
        .left{
            text-align: left;
            width: 100%;
        }
        .price{
            text-align: center;
            color: #883158;
            font-weight: 600;
            width: 100%;
        }
        .centerContHidden{
            padding: 10px;
            width: 100%;
            display: none;
        }
        .centerContHidden .details{
            text-align: right;
        }
        .centerContHidden .details p{
            padding: 0;
            margin: 0;
        }
        .myTable{
            width: 100%;
            margin: 5px 0;
        }
        .myTable td{
            padding: 2px 5px 2px;
            border-bottom: 1px solid #eee;
        }
        .myTable tr:last-child td {
            border-bottom: 0;
        }

        @media screen and (max-width: 1370px) {
            :root {
                font-size: 13px;
            }
            .centerCont{

                width: 100%;
            }
            .rightCont{
                padding: 10px;
                width: 100%;
                border: 1px solid #eee;
                border-radius: 0;
            }
            /*.right {*/
            /*    text-align: right;*/
            /*    width: 40%;*/
            /*}*/

            /*.left {*/
            /*    text-align: left;*/
            /*    width: 60%;*/
            /*}*/
        }
        @media screen and (max-width: 1024px) {
            :root {
                font-size: 12px;
            }
            .centerCont{

                width: 100%;
            }
            .rightCont{
                padding: 10px;
                width: 100%;
                border: 1px solid #eee;
                border-radius: 0;
            }

        }

        @media screen and (max-width: 768px) {
            :root {
                font-size: 12px;
            }
        }
        @media screen and (max-width: 480px) {
            :root {
                font-size: 11px;
            }
            /*.right{*/
            /*    text-align: center;*/
            /*    width: 100%;*/
            /*}*/
            /*.left{*/
            /*    text-align: center;*/
            /*    width: 100%;*/
            /*}*/
            .price{
                text-align: center;
                color: #883158;
                font-weight: 600;
                width: 100%;
            }
            .rightCont{
                padding: 10px;
                width: 100%;
                border: 1px solid #eee;
                border-radius: 0;
            }



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
                        <a href="{{route('system.orders.mainIndex')}}" class="m-nav__link">
                            <span class="m-nav__link-text">الطلبات</span>
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
                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
                            <div class="col">
                                <form class="form-inline" style="float: right">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            @component('components.serach.dateRanger')
                                            @endcomponent
                                            @component('components.serach.input',['inputs'=>['price_from'=>'السعر من','price_to'=>'السعر الى']])
                                            @endcomponent
                                            @component('components.serach.inputwithsearch',['inputs'=>['name'=>'الاسم']])
                                            @endcomponent
                                        </div>
                                    </div>

                                </form>
                            </div>


                        </div>
                        <div class="row justify-content-center align-content-stretch">

                                <div class="col d-flex">
                                    <div class="orders_new_content">
                                        <div class="status_title">
                                            <h5>الطلبات بحالة جديد</h5>
                                        </div>
                                        <div class="orders_content" id="OrderListStatus_1">
                                            @if(isset($out1) && count($out1) > 0)
                                                @foreach($out1 as $a)
                                                    <div class="order_item" id="Order_{{$a->id}}">
                                                        <div class="titleCont">
                                                            <div class="right">
                                                                <div style="display: inline-block;width: 49%;">طلب رقم</div>
                                                                <div style="display: inline-block;width: 49%;">
                                                                    <a href="{{route('system.orders.details',$a->id)}}" style="line-height: 25px;font-weight: bold;">
                                                                        <span>{{str_pad($a->id,5,'0',STR_PAD_LEFT)}}</span>
                                                                        <span>#</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
{{--                                                        <div class="rightCont">--}}
{{--                                                            <img src="{{@$a->user->image_thumbnail}}" class="img_table" alt="">--}}
{{--                                                            <div class="price"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</div>--}}

{{--                                                        </div>--}}
                                                        <div class="centerCont">

                                                            <div class="details">
                                                                <table class="myTable" style="padding: 3px;">
                                                                    <tr >
                                                                        <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">السعر الاجمالي</td>
                                                                        <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">عدد المنتجات</td>
                                                                        <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->products()->count()}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">طريقة الدفع</td>
                                                                        <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->paymentType->name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الانشاء</td>
                                                                        <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->created_at->toDateString()}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الاستلام المتوقع</td>
                                                                        <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->expected_delivery_time}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">مقدم الطلب</td>
                                                                        <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{@$a->user->name}}</td>
                                                                    </tr>

                                                                </table>
                                                            </div>
                                                            <hr style="margin-top:.1rem;margin-bottom: .1rem;">
                                                        </div>
                                                        <div class="left">
                                                            <div class="new_actions">
                                                                <a href="{{route('system.orders.details',$a->id)}}"
                                                                   class="btn btn-sm btn-outline-info m-btn m-btn--custom"
{{--                                                                   data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"--}}
                                                                   style="width: 100%!important;margin: 3px 0px;"
                                                                >
                                                                    <i class="fa fa-desktop"></i> عرض </a>
                                                                @if(in_array($a->case_id,[1,2]) )

                                                                    <button type="button"
                                                                            data-id="{{$a->id}}"
                                                                            data-url="{{route('system.orders.delete')}}"
                                                                            data-token="{{csrf_token()}}"
{{--                                                                            data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"--}}
                                                                            class="btn btn-sm btn-outline-danger m-btn m-btn--custom btn-del2"
                                                                            style="width: 100%!important;margin: 3px 0px;">
                                                                        <i class="fa fa-trash "></i>
                                                                        حذف
                                                                    </button>

                                                                @endif
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="note note-info">
                                                    <h5 class="block">لا يوجد بيانات للعرض</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                             <div class="col d-flex">
                                <div class="orders_new_content">
                                    <div class="status_title">
                                        <h5>الطلبات بحالة مؤكد</h5>
                                    </div>
                                    <div class="orders_content" id="OrderListStatus_2">
                                        @if(isset($out2) && count($out2) > 0)
                                            @foreach($out2 as $a)
                                            <div class="order_item" id="Order_{{$a->id}}">
                                                <div class="titleCont">
                                                    <div class="right">
                                                        <div style="display: inline-block;width: 49%;">طلب رقم</div>
                                                        <div style="display: inline-block;width: 49%;">
                                                            <a href="{{route('system.orders.details',$a->id)}}" style="line-height: 25px;font-weight: bold;">
                                                                <span>{{str_pad($a->id,5,'0',STR_PAD_LEFT)}}</span>
                                                                <span>#</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
{{--                                                <div class="rightCont">--}}

{{--                                                    <img src="{{@$a->user->image_thumbnail}}" class="img_table" alt="">--}}
{{--                                                    <div class="price"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</div>--}}

{{--                                                </div>--}}
                                                <div class="centerCont">

                                                    <div class="details">
                                                        <table class="myTable" style="padding: 3px;">
                                                            <tr >
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">السعر الاجمالي</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">عدد المنتجات</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->products()->count()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">طريقة الدفع</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->paymentType->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الانشاء</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->created_at->toDateString()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الاستلام المتوقع</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->expected_delivery_time}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">مقدم الطلب</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{@$a->user->name}}</td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                    <hr style="margin-top:.1rem;margin-bottom: .1rem;">
                                                </div>
                                                <div class="left">
                                                    <div class="new_actions">
                                                        <a href="{{route('system.orders.details',$a->id)}}"
                                                           class="btn btn-sm btn-outline-info m-btn m-btn--custom"
                                                           style="width: 100%!important;margin: 3px 0px;"
{{--                                                           data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"--}}
                                                        >
                                                            <i class="fa fa-desktop"></i> عرض </a>
                                                        @if(in_array($a->case_id,[1,2]) )

                                                            <button type="button"
                                                                    data-id="{{$a->id}}"
                                                                    data-url="{{route('system.orders.delete')}}"
                                                                    data-token="{{csrf_token()}}"
{{--                                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"--}}
                                                                    class="btn btn-sm btn-outline-danger m-btn m-btn--custom btn-del2"
                                                                    style="width: 100%!important;margin: 3px 0px;">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>

                                                        @endif
                                                    </div>

                                                </div>




                                            </div>

                                            @endforeach
                                        @else
                                            <div class="note note-info">
                                                <h5 class="block">لا يوجد بيانات للعرض</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col d-flex">
                                <div class="orders_new_content">
                                    <div class="status_title">
                                        <h5>الطلبات بحالة قيد الذبح</h5>
                                    </div>
                                    <div class="orders_content" id="OrderListStatus_3">
                                        @if(isset($out3) && count($out3) > 0)
                                            @foreach($out3 as $a)
                                            <div class="order_item" id="Order_{{$a->id}}">
                                                <div class="titleCont">
                                                    <div class="right">
                                                        <div style="display: inline-block;width: 49%;">طلب رقم</div>
                                                        <div style="display: inline-block;width: 49%;">
                                                            <a href="{{route('system.orders.details',$a->id)}}" style="line-height: 25px;font-weight: bold;">
                                                                <span>{{str_pad($a->id,5,'0',STR_PAD_LEFT)}}</span>
                                                                <span>#</span>
                                                            </a>
                                                        </div>
                                                    </div>

                                                </div>
{{--                                                <div class="rightCont">--}}

{{--                                                    <img src="{{@$a->user->image_thumbnail}}" class="img_table" alt="">--}}
{{--                                                    <div class="price"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</div>--}}

{{--                                                </div>--}}
                                                <div class="centerCont">

                                                    <div class="details">
                                                        <table class="myTable" style="padding: 3px;">
                                                            <tr >
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">السعر الاجمالي</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">عدد المنتجات</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->products()->count()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">طريقة الدفع</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->paymentType->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الانشاء</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->created_at->toDateString()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الاستلام المتوقع</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->expected_delivery_time}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">مقدم الطلب</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{@$a->user->name}}</td>
                                                            </tr>
                                                            @if($a->driver)
                                                                <tr>
                                                                    <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">مندوب التوصيل</td>
                                                                    <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{@$a->driver->name}}</td>
                                                                </tr>
                                                            @endif

                                                        </table>
                                                    </div>
                                                    <hr style="margin-top:.1rem;margin-bottom: .1rem;">
                                                </div>
                                                <div class="left">
                                                    <div class="new_actions">
                                                        <a href="{{route('system.orders.details',$a->id)}}"
                                                           class="btn btn-sm btn-outline-info m-btn m-btn--custom"
{{--                                                           data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"--}}
                                                           style="width: 100%!important;margin: 3px 0px;"
                                                        >
                                                            <i class="fa fa-desktop"></i> عرض </a>
                                                        @if(in_array($a->case_id,[1,2]) )

                                                            <button type="button"
                                                                    data-id="{{$a->id}}"
                                                                    data-url="{{route('system.orders.delete')}}"
                                                                    data-token="{{csrf_token()}}"
{{--                                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"--}}
                                                                    class="btn  btn-sm btn-outline-danger m-btn m-btn--custom btn-del2"
                                                                    style="width: 100%!important;margin: 3px 0px;">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>

                                                        @endif
                                                    </div>

                                                </div>

                                            </div>
                                            @endforeach
                                        @else
                                            <div class="note note-info">
                                                <h5 class="block">لا يوجد بيانات للعرض</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col d-flex">
                                <div class="orders_new_content">
                                    <div class="status_title">
                                        <h5>الطلبات بحالة قيد التوصيل</h5>
                                    </div>
                                    <div class="orders_content" id="OrderListStatus_4">
                                        @if(isset($out4) && count($out4) > 0)
                                            @foreach($out4 as $a)
                                            <div class="order_item" id="Order_{{$a->id}}">
                                                <div class="titleCont">
                                                    <div class="right">
                                                        <div style="display: inline-block;width: 49%;">طلب رقم</div>
                                                        <div style="display: inline-block;width: 49%;">
                                                            <a href="{{route('system.orders.details',$a->id)}}" style="line-height: 25px;font-weight: bold;">
                                                                <span>{{str_pad($a->id,5,'0',STR_PAD_LEFT)}}</span>
                                                                <span>#</span>
                                                            </a>
                                                        </div>
                                                    </div>


                                                </div>
{{--                                                <div class="rightCont">--}}

{{--                                                    <img src="{{@$a->user->image_thumbnail}}" class="img_table" alt="">--}}
{{--                                                    <div class="price"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</div>--}}

{{--                                                </div>--}}
                                                <div class="centerCont">

                                                    <div class="details">
                                                        <table class="myTable" style="padding: 3px;">
                                                            <tr >
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">السعر الاجمالي</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">عدد المنتجات</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->products()->count()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">طريقة الدفع</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->paymentType->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الانشاء</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->created_at->toDateString()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">تاريخ الاستلام المتوقع</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{$a->expected_delivery_time}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">مقدم الطلب</td>
                                                                <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{@$a->user->name}}</td>
                                                            </tr>
                                                            @if($a->driver)
                                                                <tr>
                                                                    <td style="padding-right: 3px!important;text-align: right;font-size: 12px;font-weight: bold;padding: 1px;">مندوب التوصيل</td>
                                                                    <td style="text-align: left;font-weight:bold;float: left;-moz-padding-end: 5px;-webkit-padding-end: 5px;">{{@$a->driver->name}}</td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                    <hr style="margin-top:.1rem;margin-bottom: .1rem;">
                                                </div>
                                                <div class="left">
                                                    <div class="new_actions">
                                                        <a href="{{route('system.orders.details',$a->id)}}"
                                                           class="btn  btn-sm btn-outline-info m-btn m-btn--custom"
{{--                                                           data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"--}}
                                                           style="width: 100%!important;margin: 3px 0px;"
                                                        >
                                                            <i class="fa fa-desktop"></i> عرض </a>
                                                        @if(in_array($a->case_id,[1,2]) )

                                                            <button type="button"
                                                                    data-id="{{$a->id}}"
                                                                    data-url="{{route('system.orders.delete')}}"
                                                                    data-token="{{csrf_token()}}"
{{--                                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"--}}
                                                                    class="btn btn-sm btn-outline-danger m-btn m-btn--custom btn-del2"
                                                                    style="width: 100%!important;margin: 3px 0px;">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>

                                                        @endif
                                                    </div>

                                                </div>



                                            </div>
                                            @endforeach
                                        @else
                                            <div class="note note-info">
                                                <h5 class="block">لا يوجد بيانات للعرض</h5>
                                            </div>
                                        @endif
                                    </div>
                                </div>
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
        $("body").on('click', '.btn-del2',

            function () {

                var Id = $(this).data('id');
                var url = $(this).data('url');
                var token = $(this).data('token');
                var thisF = $(this);
                swal(
                    {

                        title: "هل انت متأكد ؟",
                        text: "هل تريد بالتأكيد حذف الطلب رقم "+ Id,
                        type: "warning",
                        showCancelButton: 1,
                        confirmButtonText: "نعم , قم بالحذف !",
                        cancelButtonText: "لا, الغي العملية !",
                        reverseButtons: 1
                    }).then(function (e) {
                    if (e.value) {
                        $.post(url,
                            {
                                _token: token,
                                id: Id,
                            },
                            function (data, status) {
                                if (data.done == 1) {
                                    swal({
                                        title: 'تم الحذف بنجاح',
                                        text: data.msg,
                                        type: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    }).then(
                                        function () {
                                            var d = thisF.parents('.order_item');
                                            d.css('background', '#f00').fadeOut(600, function() {
                                                d.remove();
                                            });
                                        }
                                    )
                                } else {
                                    swal({
                                        title: 'حدث خطأ ',
                                        text: data.msg,
                                        type: 'error',
                                        timer: 4000,
                                        showConfirmButton: false
                                    })
                                }
                            }).fail(function (data2, status) {
                            var data2 = data2.responseJSON;
                            swal({
                                title: 'خطأ',
                                text: data2.response_message,
                                type: 'error',
                                timer: 4000,
                                showConfirmButton: false
                            })
                        });
                    } else {
                        e.dismiss && swal("تم الالغاء", "لم يتم عمل اي تغيير", "error");
                    }
                });
            });
    </script>
@endsection
