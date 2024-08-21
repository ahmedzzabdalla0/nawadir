@extends('layouts.admin')
@php
    $Disname='محفظة المستخدم';
    $subDisname='الحركات المالية';
    $icon='far fa-money-bill-alt';
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
                        <a href="{{route('system.balance.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">{{$subDisname}}</span>
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
                                    {{" $subDisname    للمستخدم $out->name "}}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
                            <div class="col">
                                <form class="form-inline" style="float: right">
                                    <div class="form-group m-form__group">
                                        <div class="input-group input-daterange">
                                            <input type="text" readonly name="date_from" value="{{ request('date_from') }}" class="form-control m-input m-input--pill" placeholder="من تاريخ">
                                            <button type="button" class="reset_field" style="right: 41% !important;left: auto !important;"><i class="fa fa-times"></i></button>
                                            <input type="text" readonly name="date_to" value="{{ request('date_to') }}" class="form-control m-input m-input--pill" placeholder="الى تاريخ">
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
                        <table class="table table-bordered">
                            <tr>
                                <td>اسم الطالب</td>
                                <td>{{$out->name}}</td>
                                <td>رقم الجوال</td>
                                <td>{{$out->mobile}}</td>
                            </tr>
                            <tr>
                                <td>اجمالي الرصيد المدفوع</td>
                                <td>
                                    <span class="{{$out->NegBalance > 0?'text-success':'text-danger'}}">{{$out->NegBalance}} {{HELPER::set_if($config['currency_ar'])}}</span>
                                </td>
                                <td>اجمالي الرصيد المضاف</td>
                                <td>
                                    <span class="{{$out->PosBalance > 0?'text-success':'text-danger'}}">{{$out->PosBalance}} {{HELPER::set_if($config['currency_ar'])}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>اجمالي الرصيد</td>
                                <td colspan="3">
                                    <span class="{{$out->balance > 0?'text-success':'text-danger'}}">{{$out->balance}} {{HELPER::set_if($config['currency_ar'])}}</span>
                                </td>

                            </tr>
                        </table>
                        @if(isset($balances) && count($balances) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr >


                                        <th>#</th>

                                        <th class="text-center">النوع</th>
                                        <th class="text-center">المبلغ</th>
                                        <th class="text-center">الطلب</th>
                                        <th class="text-center">تاريخ العملية</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $colors=['#f0f0f0','#fdfdfd','#f6f6f6','#fcfcfc','#f7f7f7','#fbfbfb','#f2f2f2','#fafafa','#f5f5f5','#f3f3f3'];$count=0;$sel=0;?>
                                    @foreach($balances as $o)
                                            <tr id="TR_{{$o->id}}" @if($o->IsAlone >1) style="background: {{$colors[$sel]}}" @endif>
                                                <?php
                                                $count++;
                                                if($o->is_alone == $count){
                                                    $sel==(count($colors)-1)?$sel=0:$sel++;
                                                    $count=0;
                                                }
                                                ?>

                                                <td class="LOOPIDS">{{$loop->iteration}}</td>

                                                <td class="text-center">
                                                        <p style="color:#000; font-weight: 600">{{$o->Btype->name}}</p>
                                                </td>
                                                <td class="text-center"> <p class="{{$o->amount > 0?'text-success':'text-danger'}}">{{$o->amount}} {{HELPER::set_if($config['currency_ar'])}}</p></td>
                                                <td class="text-center">
                                                    @cando('view','orders')
                                                    @if($o->order)
                                                    <a href="{{ route('system.orders.details',$o->order->id)}}" >#{{str_pad($o->order->id,4,'0',STR_PAD_LEFT)}} ({{@$o->order->products()->count()}}  منتج)</a>
                                                    @else
                                                        لا ينتمي لطلب
                                                    @endif
                                                    @elsecando
                                                    {{$o->order_id}}
                                                    @endcando
                                                </td>
                                                <td class="text-center"> {{\Carbon\Carbon::parse($o->created_at)->format('Y/m/d  \الساعة  h:i a')}}</td>
                                            </tr>
                                    @endforeach
                                    {{--<tr>--}}

                                        {{--<td></td>--}}
                                        {{--<td></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                        {{--<td class="text-center"></td>--}}
                                    {{--</tr>--}}
                                    </tbody>
                                </table>
                            </div>

                            {!! $balances->links() !!}
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
