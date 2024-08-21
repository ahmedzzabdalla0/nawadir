@extends('layouts.admin')
@php
    $Disname='الادارة';
    $icon='fas fa-user-cog';

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
                                @cando('add','admins')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.admin.create')}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
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
                                                        @cando('delete','admins')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.admin.delete')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon flaticon-delete "></i>
                                                                <span class="m-nav__link-text">حذف</span>
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
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
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

                                        <th>  الاسم</th>
                                        <th>  اسم المستخدم</th>
                                        <th>  الجوال</th>
                                        {{--<th> الحالة</th>--}}
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                @if($o->id !=1)
                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                        <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                        <span></span>
                                                    </label>

                                                @endif
                                            </td>
                                            <td>
                                                <img src="{{$o->image_url}}" class="img_table" alt="">
                                                {{$o->name}}</td>
                                            <td>{{$o->email}}</td>
                                            <td>{{$o->mobile}}</td>
                                            {{--                                <td>{{$o->status == 1?'مفعل':'معطل'}}</td>--}}

                                            <td class="text-center">
                                                @if($o->id !=1)
                                                    <ul class="list-inline">

                                                        @cando('edit','admins')
                                                        <li>
                                                            <a href="{{route('system.admin.update',$o->id)}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="تعديل البيانات"
                                                            >
                                                                <i class="fa fa-edit"></i> تعديل </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{route('system.admin.permission',$o->id)}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-warning m-btn m-btn--custom"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="تعديل الصلاحيات"
                                                            >
                                                                <i class="fa fa-list"></i> الصلاحيات </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{route('system.admin.password',$o->id)}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-metal m-btn m-btn--custom"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="تعديل كلمة المرور">
                                                                <i class="fa fa-lock"></i> كلمة المرور </a>
                                                        </li>
                                                        @endcando
                                                        @cando('delete','admins')
                                                        <li>
                                                            <button type="button"
                                                                    data-id="<?= $o->id ?>"
                                                                    data-url="{{route('system.admin.delete')}}"
                                                                    data-token="{{csrf_token()}}"
                                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>


                                                        </li>
                                                        @endcando
                                                    </ul>
                                                @endif
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
