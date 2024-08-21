@extends('layouts.admin')
@php
    $Disname='الدول';
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
                        <a href="{{route('system_admin.generalProperties')}}" class="m-nav__link">
                            <span class="m-nav__link-text">الخصائص العامة</span>
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
                                                <i class="flaticon-user-settings"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                                @cando('add','areas')
                                <li class="m-portlet__nav-item" style="display: none;">
                                    <a href="{{route('system.countries.create')}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة</span>
                                    </a>
                                </li>
                                @endcando
                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle btn m-btn--pill m-btn--air btn-outline-warning m-btn m-btn--custom">
                                        <i class="fa fa-cog"></i>
                                        <span>العمليات</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        @cando('delete','areas')
                                                        <li class="m-nav__item" style="display:none;">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.countries.delete')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon flaticon-delete "></i>
                                                                <span class="m-nav__link-text">حذف</span>
                                                            </a>
                                                        </li>
                                                        @endcando
                                                        @cando('activate','countries')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.countries.activate')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-lock-open"></i>
                                                                <span class="m-nav__link-text">تفعيل</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.countries.deactivate')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-lock "></i>
                                                                <span class="m-nav__link-text">تعطيل</span>
                                                            </a>
                                                        </li>
                                                        @endcando
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="m-portlet__body">
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;display: none;">
                            <div class="col">
                                <form class="form-inline" style="float: right">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <input type="text" name="name" class="form-control m-input m-input--pill" placeholder="الاسم">
                                            <div class="input-group-append">
                                                <button class=" btn m-btn--pill btn-outline-info m-btn" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        @if(isset($out) && count($out) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr >
                                        <th>#</th>
                                        <th width="5%" style="text-align: center;vertical-align: middle;">
                                            <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                <input type="checkbox" id="SelectAll">
                                                <span></span>
                                            </label>
                                        </th>
                                        <th>عنوان الدولة بالعربيه</th>
                                        <th>عنوان الدولة بالانجليزيه</th>
                                        <th style="width: 100px;">علم الدولة</th>
                                        <th>مفتاح الدولة</th>
                                        <th>عدد خانات رقم الجوال</th>
                                        <th>الحالة</th>
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">
                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                        <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                        <span></span>
                                                    </label>
                                            </td>
                                            <td>{{$o->name_ar}}</td>
                                            <td>{{$o->name_en}}</td>
                                            <td class="">
                                                <img width="70" height="70" src="{{url('uploads/'.$o->flag)}}"  alt="">
                                            </td>
                                            <td>{{$o->prefix}}</td>
                                            <td>{{$o->mobile_digits}}</td>
                                            <td>@if($o->status == 1)
                                                    <span class="m-btn--pill btn-sm m-btn--air btn-success m-btn m-btn--custom">مفعل</span>
                                                @elseif($o->status == 0 )
                                                    <span class="m-btn--pill btn-sm m-btn--air btn-danger m-btn m-btn--custom">معطل</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                    <ul class="list-inline">
                                                        @cando('view','areas')
                                                        <li>
                                                            <a href="{{route('system.areas.index',['id'=>$o->id])}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض المدن"
                                                            >
                                                                <i class="fa fa-box-open"></i> عرض المحافظات </a>
                                                        </li>
                                                        @endcando
                                                        @cando('edit','areas')
                                                        <li>
                                                            <a href="{{route('system.countries.update',$o->id)}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="تعديل البيانات"
                                                            >
                                                                <i class="fa fa-edit"></i> تعديل </a>
                                                        </li>
                                                        @endcando
                                                        @cando('delete','areas')
                                                        <div style="display: none;">
                                                        @if($o->can_del )
                                                        <li>
                                                            <button type="button"
                                                                    data-id="<?= $o->id ?>"
                                                                    data-url="{{route('system.countries.delete')}}"
                                                                    data-token="{{csrf_token()}}"
                                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del"
                                                            >
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>
                                                        </li>
                                                        @else
                                                            <li>
                                                                <button type="button"
                                                                        data-skin="dark"  data-tooltip="m-tooltip"
                                                                        data-placement="top" title="لا يمكن الحذف"
                                                                        disabled
                                                                        class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom disabled">
                                                                    <i class="fa fa-trash "></i>
                                                                    حذف
                                                                </button>
                                                            </li>
                                                        @endif
                                                        </div>
                                                        @endcando
                                                    </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
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
