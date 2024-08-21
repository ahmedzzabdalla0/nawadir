@extends('layouts.admin')

@php
    $Disname='محفظة المستخدم';
    $icon=' fas fa-wallet';
@endphp
@section('title',  $Disname)
@section('head')

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

                <div class="col-md-12">
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
                                                <input type="text" name="mobile"
                                                       class="form-control m-input m-input--pill"
                                                       placeholder="بحسب الجوال" value="{{ request('mobile') }}">
                                                <input type="text" name="email"
                                                       class="form-control m-input m-input--pill"
                                                       placeholder="بحسب الايميل" value="{{ request('email') }}">
                                                <input type="text" name="name"
                                                       class="form-control m-input m-input--pill"
                                                       placeholder="بحسب الاسم" value="{{ request('name') }}">
                                                <div class="input-group-append">
                                                    <button class=" btn m-btn--pill btn-outline-info m-btn"
                                                            type="submit"><i
                                                                class="fa fa-search"></i></button>
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
                                        <tr>


                                            <th>#</th>
                                            {{--<th width="5%" style="text-align: center;vertical-align: middle;">--}}
                                            {{--<label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">--}}
                                            {{--<input type="checkbox" id="SelectAll">--}}
                                            {{--<span></span>--}}
                                            {{--</label>--}}

                                            {{--</th>--}}
                                            <th class="text-center">الإسم</th>
                                            <th class="text-center">رقم الجوال</th>
                                            <th class="text-center">المدفوعات</th>

                                            <th class="text-center">المضافات</th>
                                            <th class="text-center">الرصيد الحالي</th>
                                            <th class="text-center">الإعدادات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($out as $o)
                                            <tr id="TR_{{$o->id}}">

                                                <td class="LOOPIDS">{{$loop->iteration}}</td>

                                                <td class="text-center"><a
                                                            href="{{route('system.users.details',$o->id)}}">{{str_limit($o->name, 30)}}</a>
                                                </td>
                                                <td class="text-center"> {{$o->mobile??'-'}}</td>
                                                <td class="text-center"><span class="text-danger">{{$o->neg_balance . ' '.HELPER::set_if($config['currency_ar'])}}</span></td>
                                                <td class="text-center"> <span class="text-success">{{$o->pos_balance . ' '.HELPER::set_if($config['currency_ar'])}}</span></td>
                                                <td class="text-center">{{$o->balance . ' '.HELPER::set_if($config['currency_ar'])}}</td>
                                                <td class="text-center">
                                                    <ul class="list-inline">
                                                        @cando('view','balance')
                                                        <li>
                                                            <a href="{{route('system.balance.userBalance',$o->id)}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-warning m-btn m-btn--custom"
                                                               data-skin="dark" data-tooltip="m-tooltip"
                                                               data-placement="top" title="الحركات المالية"
                                                            >
                                                                <i class="far fa-money-bill-alt"></i> الحركات المالية
                                                            </a>
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
            </div>
@endsection

@section('custom_scripts')
@endsection
