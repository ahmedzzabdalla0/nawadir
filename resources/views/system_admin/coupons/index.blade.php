@extends('layouts.admin')
@php
    $Disname='كوبونات الخصم';
    $icon='fas fa-ticket-alt';
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
                                @cando('add','coupons')
                                <div class="m-card-profile__details">
                                    <a href="{{route('system.coupons.create')}}"
                                       style="margin: 3px;width: 100%;"
                                       class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom"
                                    ><i class="fa fa-plus"></i>
                                        <span>إضافة</span>
                                    </a>
                                </div>
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
                                                        @cando('delete','coupons')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.coupons.delete')}}"
                                                               data-desc="حذف"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon flaticon-delete "></i>
                                                                <span class="m-nav__link-text">حذف</span>
                                                            </a>
                                                        </li>

                                                        @endcando

                                                        @cando('activate','coupons')
                                                        <hr>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.coupons.activate')}}"
                                                               data-desc="تفعيل"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-lock-open"></i>
                                                                <span class="m-nav__link-text">تفعيل</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.coupons.deactivate')}}"
                                                               data-desc="تعطيل"
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
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
                            <div class="col">
                                <form class="form-inline">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <select name="status" class="autoSubmit filter-input" id="" >
                                                <option {{  is_null(request('status')) || request('status') == -1 ?'selected':'selected'}} value="-1">بحث حسب الحالة</option>
                                                <option {{  !is_null(request('status')) && request('status') == 1?'selected':''}} value="1">فعال</option>
                                                <option {{ !is_null(request('status')) &&  request('status') == 0?'selected':''}} value="0">منتهي</option>
                                            </select>
                                        </div>
                                        <div class="input-group input-daterange">
                                            <input type="text" readonly name="start_date" value="{{HELPER::set_if($_GET['start_date'])}}" class="form-control m-input m-input--pill  filter-input" placeholder="من تاريخ">
                                            <button type="button" class="reset_field filter-reset"><i class="fa fa-times"></i></button>
                                            <input type="text" readonly name="end_date" value="{{HELPER::set_if($_GET['end_date'])}}" class="form-control m-input m-input--pill  filter-input" placeholder="الى تاريخ">

                                        </div>
                                        <div class="input-group" >
                                            <input type="text" name="code" class="form-control m-input m-input--pill filter-input" placeholder="كود الكوبون" value="{{ request('code') }}">
                                            <div class="input-group-append">
                                                <button class=" btn m-btn--pill btn-outline-info m-btn filter-btn" type="submit"><i class="fa fa-search"></i></button>
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
                                        <th class="text-right">كود الخصم</th>
                                        <th class="text-center">نسبة الخصم</th>
                                        <th class="text-center">من تاريخ</th>
                                        <th class="text-center">الى تاريخ</th>
                                        <th class="text-center">عدد مرات الاستخدام المسموحة</th>
                                        <th class="text-center">عدد مرات الاستخدام</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الاعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{($out ->currentpage()-1) * $out ->perpage() + $loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                    <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td class="text-right">
                                                {{ $o->code }}
                                            </td>
                                            <td class="text-center"> {{ $o->amount.'%' }}</td>
                                            <td class="text-center"> {{ $o->start_date }}</td>
                                            <td class="text-center"> {{ $o->end_date }}</td>
                                            <td class="text-center"> {{ $o->valid_count }}</td>
                                            <td class="text-center"> {{ $o->used_count }}</td>
                                            <td class="text-center">
                                               @if($o->is_valid && !\Carbon\Carbon::now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($o->end_date)) && $o->used_count < $o->valid_count)

                                                        <span class="m--font-success">فعال</span>
                                                @else
                                                    <span class="m--font-danger">منتهي</span>
                                                @endif

                                            </td>
                                            {{--<td class="text-center"> {{@$o->created_at->toDateString()}}</td>--}}
                                            <td class="text-center">

                                                <ul class="list-inline">
                                                    @cando('delete','coupons')
                                                        <li>
                                                            @if($o->can_del)
                                                            <button type="button"
                                                                    data-id="<?= $o->id ?>"
                                                                    data-url="{{route('system.coupons.delete')}}"
                                                                    data-token="{{csrf_token()}}"
                                                                    data-skin="dark" data-tooltip="m-tooltip"
                                                                    data-placement="top" title="حذف"
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>
                                                            @else
                                                                <span data-skin="dark" data-tooltip="m-tooltip"
                                                                      data-placement="top" title="لا يمكن الحذف لوجود طلبات متعلقة به">
                                                                     <button type="button"
                                                                             disabled
                                                                             data-id="<?= $o->id ?>"
                                                                             data-url="{{route('system.coupons.delete')}}"
                                                                             data-token="{{csrf_token()}}"
                                                                             data-skin="dark" data-tooltip="m-tooltip"
                                                                             data-placement="top" title=""
                                                                             class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                                    <i class="fa fa-trash "></i>
                                                                    حذف
                                                                </button>
                                                                </span>

                                                            @endif

                                                        </li>
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

