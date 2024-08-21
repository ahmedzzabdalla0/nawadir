@extends('layouts.admin')
@php
    $Disname='حركات المخزون';
    $icon='fa fa-history';
@endphp
@section('title', $Disname)
@section('head')
    <style>
        div.abs_error{
            position: unset!important;
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
                        <a href="{{route('system.products.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">المنتجات</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text"> {{$product->name}} </span>
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
                                @cando('add','products')
                                <li class="m-portlet__nav-item">

{{--                                    <a href="{{route('system.products.create_log',['product_id'=>$product->id])}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">--}}
{{--                                        <i class="fa fa-plus"></i>--}}
{{--                                        <span>إضافة</span>--}}
{{--                                    </a>--}}
{{--                                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">--}}
{{--                                        <i class="fa fa-plus"></i>--}}
{{--                                        <span>إضافة</span>--}}
{{--                                    </a>--}}
                                </li>
                                @endcando
                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">
                        <div class="row" id="collapseExample" >
                            <h5 style="padding: 15px;"><i class="fa fa-plus-circle"></i> <span>اضافة حركة مخزون للمنتج:</span></h5>
                            <form class="form-inline" style="padding-right:15px;width: 100%;" action="{{route('system.products.do.create_log')}}" id="form" method="post">

                                @csrf
                                       <input name="product_id" type="hidden" value="{{$product->id}}">
                                        @if(count($product->variants) > 1)
                                    <div class="form-group m-form__group" style="height:50px!important;margin-left:5px;width: 20%;display: inline-block">
                                        <select required search="true" class="m-input m-input--pill m-input--air" name="product_variant_id" id="product_variant_id" required>
                                            @forelse($product_variants as $parent)
                                                <option value="{{ $parent->id }}"  {{ old('product_variant_id')==$parent->id?'selected':'' }}>{{ $parent->name }}</option>
                                            @empty
                                            @endforelse
                                        </select>
                                        @show_error('product_variant_id')
                                    </div>
                                        @endif

                                       <div class="form-group m-form__group" style="height:50px!important;margin-left:5px;width: 20%;display: inline-block">
                                           <select required  name="type" id="type" >
                                               <option value="AddToStock">اضافة كمية</option>
                                               <option value="GetFromStock">سحب كمية</option>
                                               <option value="BuyFromStock">بيع كمية</option>
                                           </select>
                                           @show_error('type')
                                       </div>
                                       <div class="form-group m-form__group" style="height:50px!important;width: 17%;display: inline-block">
                                           <input required min="1" type="number" name="qty"  value="{{old('qty')}}" class="form-control m-input m-input--pill" placeholder="الكمية">
                                           @show_error('qty')
                                       </div>
                                       <div class=" form-group m-form__group" style="height:50px!important;width: 17%;display: inline-block">
                                           <input required min="1" type="number" name="price"  value="{{old('price')}}" class="form-control m-input m-input--pill" placeholder="سعر الشراء">
                                           @show_error('price')
                                       </div>

                                       <div class="form-group m-form__group" style="height:50px!important;width: 10%;display: inline-block">
                                           <button class=" btn m-btn--pill btn-outline-info m-btn" type="submit"> <i class="fa fa-check"></i>
                                               <span>اضافة</span></button>
                                       </div>



                            </form>

                        </div>
                        <hr>
                        @if(isset($out) && count($out) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr >


                                        <th>#</th>
                                        <th class="text-center">المنتج</th>

                                        <th class="text-center">السعر</th>
                                        <th class="text-center">نوع الحركة</th>
                                        <th class="text-center">رقم الطلب</th>

                                        <th class="text-center">تاريخ الحركة</th>
                                        <th class="text-center">وقت الحركة</th>
                                        <th class="text-center">الكمية</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td class="text-center">
                                                {{$o->productVariant?$o->productVariant->name:$o->product->name}}
                                            </td>
                                            <td class="text-center"> {{@$o->price}} {{HELPER::set_if($config['currency_ar'])}}</td>
                                            <td class="text-center">
                                                @if($o->type == 'AddToStock')
                                                    <span class="m--font-success"> اضافة منتج </span>
                                                @elseif($o->type == 'GetFromStock')
                                                    <span class="m--font-danger"> سحب منتج </span>
                                                @else
                                                    <span class="m--font-danger"> شراء منتج </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($o->order_id )
                                                    @if($o->order)
                                                        @cando('view','orders')
                                                        <a
                                                            href="{{route('system.orders.details',['id'=>$o->order_id])}}"> {{$o->order_id?'#'.$o->order_id:'-'}}</a>

                                                        @elsecando
                                                        {{$o->order_id?'#'.$o->order_id:'-'}}
                                                        @endcando
                                                    @else
                                                       {{'#'.$o->order_id}}
                                                    @endif

                                                @else
                                                    -
                                                @endif

                                            </td>

                                            <td class="text-center"> {{@$o->created_at->toDateString()}}</td>
                                            <td class="text-center"> {{@$o->created_at->toTimeString()}}</td>
                                            <td class="text-center">
                                                @if($o->amount > 0)
                                                    <span class="m--font-success"> {{$o->amount}} </span>
                                                @else
                                                    <span class="m--font-danger"> {{$o->amount}} </span>
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                    <tr style="background-color: #b6daa8;font-weight: bold; ">
                                        <td colspan="7">المجموع</td>
                                        <td >
                                            {{$product->available_quantity}}
                                        </td>
                                    </tr>
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
@section('custom_scripts')



    <script>

        $(function () {

            $('#form').validate({

                errorElement: 'div', //default input error message container

                errorClass: 'abs_error help-block has-error',


            }).init();

        })



    </script>



@endsection
