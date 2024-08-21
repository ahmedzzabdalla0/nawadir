@extends('layouts.admin')
@php
    $Disname='مندوبين التوصيل';
    $icon='fas fa-car';

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
                        <a href="{{route('system.drivers.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$driver->name}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">الطلبات</span>
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
                                            @component('components.serach.select',['key'=>'status_id',
                                   'text'=>'اختر الحالة',
                                'select'=>$statuses])
                                            @endcomponent
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
            @if(isset($out) && count($out) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">رقم الطلب</th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center">المستخدم</th>
                            <th class="text-center">مندوب التوصيل</th>
                            <th class="text-center">السعر الكلي</th>
                            <th class="text-center">عدد المنتجات</th>
                            <th class="text-center">الحالة</th>
                            <th class="text-center">الإعدادات</th>
                        </tr>
                        </thead>
                        <tbody id="OrderList" data-type="store">
                        <tr></tr>

                        @foreach($out as $a)

                            <tr id="TR_{{$a->id}}">
                                <td class="LOOPIDS">{{ ($out->currentpage()-1) * $out ->perpage() + $loop->index + 1 }}</td>
                                <td class="text-center">
                                    <a href="{{route('system.orders.details',$a->id)}}" target="_blank"> <?= $a->id ?></a>
                                </td>
                                <td class="text-center">
                                    <?= $a->name ?>
                                </td>
                                <td class="text-center">
                                    {{@$a->user->name}}
                                </td>
                                <td class="text-center">
                                    {{@$a->driver?$a->driver->name:'-'}}
                                </td>
                                <td class="text-center"><?= $a->total_price ?> {{HELPER::set_if($config['currency'])}}</td>
                                <td class="text-center">
                                    {{$a->products()->count()}}
                                </td>

                                <td class="text-center" id="STAT_<?= $a->id ?>">
                                    <span style="color: {{@$a->status->color_hex}}">{{@$a->status->name}}</span>
                                </td>
                                <td class="text-center">
                                    <ul class="list-inline">
                                        <li>
                                            <a href="{{route('system.orders.details',$a->id)}}"
                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"
                                            >
                                                <i class="fa fa-desktop"></i> عرض </a>
                                        </li>
                                        @if($a->case_id < 3)
                                            <li>
                                                <button type="button"
                                                        data-id="{{$a->id}}"
                                                        data-url="{{route('system.orders.delete')}}"
                                                        data-token="{{csrf_token()}}"
                                                        data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"
                                                        class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                    <i class="fa fa-trash "></i>
                                                    حذف
                                                </button>


                                            </li>
                                        @endif

                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$out->links()}}
                </div>
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
