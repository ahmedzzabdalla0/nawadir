@extends('layouts.admin')
@php
    $Disname='الطلبات ';
@endphp
@section('title', $Disname)

@section('head')
    <style>
        .path-item{
            background: #eee;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
            padding: 10px 20px;
        }
    </style>
    <style>

        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            html, body {
                width: 210mm;
                height: 297mm;
                background-color: #fff !important;
            }

            /* All your print styles go here */
            .page-breadcrumb {
                display: none;
            }

            .m-body {
                background-color: #fff !important;
            }

            #btn1, #btn2 {
                display: none !important;
            }

            a {
                display: none;
            }

            a.order-number {
                display: block;
            }

            .m-footer {
                display: none !important;
            }

            .hide-prnt {
                display: none !important;
            }

            .rep_a {
                display: block !important;
                margin-bottom: 20px;
            }

            #pp {
                border: 0 !important;
            }

            .table-bordered th,
            .table-bordered td {
                border: 1px solid #000 !important;
                padding: 10px;
                font-size: 16px !important;
                font-weight: 500 !important;
                font-family: sans-serif !important;
            }

        }

        .rep_a {
            display: none;
        }

        .col-sm-3, .col-sm-5, .col-sm-4, .col-sm-1, .col-sm-11 {
            padding: 2px;
        }

        .hide-td{
            border: #fff solid!important;
        }
        .table_print {
            width: 100%;
            border: 1px solid;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table_print th,
        .table_print td {
            border: 1px solid #000 !important;
            padding: 5px;
            text-align: center;
            font-size: 16px !important;
            font-weight: 500 !important;
            font-family: sans-serif !important;
        }

        #sort tr:hover {
            cursor: pointer;
        }

        #sort tr.ui-sortable-helper{
            cursor: move;
        }
        .background-color{
            background-color: #78a56038!important;
        }

        .logo {
            text-align: right;
            margin-bottom: 20px;
        }
        .logo img {
            width: 100px;
        }
        .qr-code {
            text-align: left;
            margin-bottom: 20px;
        }
        .qr-code img {
            width: 200px;
        }

    </style>
@endsection

@section('page_content')
    <div class="m-subheader hide-prnt">
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
                    <div class="m-portlet__head hide-prnt">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon">
                                                <i class="flaticon-line-graph"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
{{--                                <li class="m-portlet__nav-item">--}}

{{--                                    <button class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom"--}}
{{--                                            id="btn2" type="button" onclick="myFunction()" style="padding: 10px;">--}}
{{--                                        <i class="fa fa-print"></i>--}}
{{--                                        <span>طباعة</span>--}}
{{--                                    </button>--}}
{{--                                </li>--}}

                            </ul>
                        </div>
                        <?php 
                        
                        
                            function  zatca_base64_tlv_encode($seller_name, $vat_registration_number, $invoice_datetimez, $invoice_amount, $invoice_tax_amount)
    {
        $result = chr(1) . chr( strlen($seller_name) ) . $seller_name;
        $result.= chr(2) . chr( strlen($vat_registration_number) ) . $vat_registration_number;
        $result.= chr(3) . chr( strlen($invoice_datetimez) ) . $invoice_datetimez;
        $result.= chr(4) . chr( strlen($invoice_amount) ) . $invoice_amount;
        $result.= chr(5) . chr( strlen($invoice_tax_amount) ) . $invoice_tax_amount;
        return base64_encode($result);
    }?>


                    </div>
                    <div class="m-portlet__body">
                        <div class="row">
                            <div class="col">
                                <div class="logo">
                                    <img src="https://nwader.sa/admin/imgs/logo_w.png" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="qr-code">
                                  <img src="https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl={{zatca_base64_tlv_encode("نوادر القصيم",'1234567',@$out->created_at->toDateString(),$out->total_price,$out->tax_price)}}" />
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-10">
                                <table class="table table-bordered" style="text-align: center;">

                                    <tr>
                                        <td colspan="4" style="font-weight: 600">بيانات صاحب الطلب</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">الاسم</td>
                                        <td>{{@$out->user->name}}</td>
                                        <td style="font-weight: 600">الجوال</td>
                                        <td>{{@$out->user->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">الايميل</td>
                                        <td>{{@$out->user->email??'-'}}</td>
                                        <td style="font-weight: 600">تاريخ التقديم</td>
                                        <td>{{@$out->created_at->toDateString()}}</td>

                                    </tr>


                                </table>

                            </div>
                            <div class="col-md-2 hide-prnt">
                                <h3 style="text-align: center;">العمليات</h3>
                                <button class="btn btn-primary btn-block" onclick="myFunction()">طباعة</button>
                                <?php if ($out->case_id == 1 && $out->payment_type == 4 && !$out->is_paid) { ?>

                                <button class="btn btn-primary btn-block btn-action-0" data-paid="not-paid"> تأكيد الطلب</button>
                                <?php } elseif ($out->case_id == 1 && in_array($out->payment_type,[1,6]) && !$out->is_paid) { ?>

                                <button class="btn btn-primary btn-block btn-action-0" data-paid="not-paid"> تأكيد الطلب</button>
                                <?php } elseif ($out->case_id == 2) { ?>

                                <a class="btn btn-primary btn-block" href="#choose_driver_modal" data-paid="paid" data-toggle="modal" data-target="#choose_driver_modal">بدء الذبح</a>
                                <?php } elseif ($out->case_id == 3) { ?>
                                <button class="btn btn-primary btn-block btn-action-1"> بدء التوصيل </button>

                                <?php } elseif ($out->case_id == 4 ) { ?>
                                <button class="btn btn-primary btn-block btn-action-2"> تسليم الطلب</button>

                                <?php } elseif ($out->case_id == 5) { ?>
                                <h4 style="text-align: center">لا يوجد عمليات </h4>
                                <h5 style="text-align: center">تم انهاء الطلب</h5>
                                <?php } else { ?>
                                <h4 style="text-align: center">لا يوجد عمليات </h4>
                                <h5 style="text-align: center">الغي الطلب</h5>
                                <?php } ?>
{{--                                @if($out->is_paid == 1 &&!$out->is_canceled_refunded && $cancel_type == 0 && $out->case_id==6)--}}
{{--                                    <button class="btn btn-primary btn-block refund-canceled" style="font-size:11px;">تأكيد ارجاع رصيد طلب ملغي</button>--}}
{{--                                @endif--}}
                                <?php if ($out->case_id < 5) { ?>
                                <button class="btn btn-danger btn-block btn-action-6">الغاء الطلب</button>
                                <?php } ?>
                                <a href="{{route('system.orders.trackOrderOnMap',['id'=>$out->id])}}" class="btn btn-primary btn-block">عرض على الخريطة</a>



                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" style="text-align: center;">

                                    <tr>
                                        <td colspan="4" style="font-weight: 600">بيانات الطلب والدفع</td>
                                    </tr>

                                    <tr>
                                        <td style="font-weight: 600">حالة الطلب</td>
                                        <td>
                                            <span style="color: {{@$out->case->color_hex}}">{{@$out->status->name}}</span>
                                        </td>
                                        <td style="font-weight: 600">المبلغ الاجمالي</td>
                                        <td><?= $out->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>

                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">عدد المنتجات</td>
                                        <td>
                                            {{$out->products()->count()}} منتج
                                        </td>
                                        <td style="font-weight: 600">طريقة الدفع</td>
                                        <td>
                                            {{$out->paymentType->name}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td style="font-weight: 600">تاريخ التسليم المتوقع</td>
                                        <td>
                                            {{$out->expected_delivery_time}}
                                        </td>
                                        <td style="font-weight: 600">مندوب التوصيل</td>
                                        <td>
                                            {{$out->driver?$out->driver->name:'-'}}
                                        </td>

                                    </tr>
                                    @if($out->payment_type == 4)
                                        <tr>
                                            <td style="font-weight: 600">اي دي الحوالة</td>
                                            <td>
                                                {{$out->transaction->transaction_id}}
                                            </td>
                                            <td style="font-weight: 600">صورة الحوالة</td>
                                            <td>
                                                <a href="{{asset('uploads/'.$out->transaction->image)}}" target="_blank">اضغ لعرض الصورة</a>
                                            </td>

                                        </tr>

                                    @endif




                                </table>

                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" style="text-align: center;">

                                    <tr>
                                        <td colspan="4" style="font-weight: 600">عنوان التسليم </td>
                                    </tr>
                                    <tr>
                                        <td>المدينة</td>
                                        <td> {{ @$out->address->gov->name }}</td>
                                        <td>الحي</td>
                                        <td>{{ @$out->address->area->name }}</td>
                                    </tr>
                                    <tr>

                                        <td>الشارع</td>
                                        <td> {{$out->address->street}} </td>
                                        <td> رقم المنزل</td>
                                        <td> {{$out->address->build_number}}</td>

                                    </tr>
                                    <tr>

                                        <td >رقم الدور</td>
                                        <td> {{$out->address->floor}}
                                        </td>
                                        <td >رقم الشقة</td>
                                        <td>{{$out->address->flat}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"> العنوان نص</td>
                                        <td colspan="2" style="max-width: 250px;"> {{$out->address->address_text}}</td>
                                    </tr>


                                </table>

                            </div>

                            <hr>
                            <?php
                            $productssum = 0;
                            ?>


                            @if($out->products()->count())
                            <div class="col-md-12">
                                <h3 style="text-align: center;margin-top: 20px;">منتجات الطلب</h3>
                                <table class="table table-bordered table-condensed" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">#</th>
                                        <th style="text-align: center">اسم المنتج</th>
                                        <th style="text-align: center">نوع التقطيع</th>
                                        <th style="text-align: center">نوع التغليف</th>
                                        <th style="text-align: center">الكمية</th>
                                        <th style="text-align: center">السعر </th>
                                        <th style="text-align: center">السعر في الطلب</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    <?php $i = 1;
                                    foreach ($out->products as $a) { ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <?= $a->productVariant->web_name ?>
                                        </td>
                                        <td>
                                            <?= $a->cut_type?$a->cut_type->name:'-' ?>
                                        </td>
                                        <td>
                                            <?= $a->is_covered?$a->cover_type->name:'بدون تغليف' ?>
                                        </td>


                                        <td>
                                            <?= $a->qty ?>
                                        </td>
                                        <td>
                                            <?= $a->productVariant->end_price ?> {{HELPER::set_if($config['currency_ar'])}}
                                        </td>

                                        <td>
                                            <?= $a->price ?> {{HELPER::set_if($config['currency_ar'])}}
                                                <?php $productssum += $a->price; ?>
                                        </td>
                                    </tr>
                                    <?php $i++;
                                    } ?>


                                        <tr>
                                            <td style="border: 0"></td>
                                            <td colspan="5" style="background: #b6daa8">المجموع </td>
                                            <td style="background: #b6daa8"><?= round( $productssum, 2) ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                        </tr>





                                    </tbody>

                                </table>

                            </div>
                            @endif
                            <div class="col-md-12">
                                <h3 style="text-align: center;margin-top: 20px;">المجموع الكلي</h3>
                                <table class="table table-bordered table-condensed" style="text-align: center">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center" width="80%"></th>
                                        <th style="text-align: center">السعر الاجمالي</th>
                                    </tr>

                                    </thead>
                                    <tbody>
                                    @if($productssum)
                                        <tr style="background: #bddabf">
                                            <td style="text-align: center" width="80%">مجموع سعر المنتجات</td>
                                            <td style="text-align: center"><?= round( $productssum , 2) ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                        </tr>
                                    @endif
                                    @if($out->slaughter_cost>0)
                                        <tr style="background: #bddabf">
                                            <td style="text-align: center" width="80%">مجموع تكلفة الذبح</td>
                                            <td style="text-align: center"><?= round( $out->slaughter_cost , 2) ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                        </tr>
                                    @endif

                                    @if($out->tax_price)
                                        <tr style="background: #dabf97">
                                            <td style="text-align: center" width="80%">مبلغ الضريبة</td>
                                            <td style="text-align: center"><?= $out->tax_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                        </tr>
                                    @endif
                                    @if($out->delivery_price)
                                        <tr style="background: #dabf97">
                                            <td style="text-align: center" width="80%">مبلغ التوصيل</td>
                                            <td style="text-align: center"><?= $out->delivery_price ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                        </tr>
                                    @endif
                                    @if($out->coupon)
                                        <tr style="background: #dabf97">
                                            <td style="text-align: center" width="80%">كوبون الخصم({{$out->coupon->code}})</td>
                                            <td style="text-align: center"><?= $out->coupon_value ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                        </tr>
                                    @endif
                                    <tr style="background: #b6daa8">
                                        <td style="text-align: center" width="80%">المجموع الكلي</td>
                                        <td style="text-align: center"><?= round( $productssum+$out->slaughter_cost+$out->tax_price+$out->delivery_price-$out->coupon_value , 2) ?> {{HELPER::set_if($config['currency_ar'])}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>




                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div id="refund_order_cost" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تأكيد ارجاع رصيد الطلب الملغب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{ route('system.orders.refundCanceledOrder') }}" method="post" id="refund_canceled_order">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="order_id" name="order_id" value="{{ $out->id }}">

                        <div class="form-group m-form__group">
                            <label for="products_price">السعر الاجمالي:</label>
                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                <input type="text" maxlength="8" disabled
                                       class="form-control m-input m-input--pill m-input--air"
                                       placeholder="السعر الاجمالي"
                                       required name="products_price" value="{{$out->total_price}}"
                                       id="products_price">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span><i class="fa fa-dollar-sign"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="refunded_price">المبلغ المرجع</label>
                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                <input type="number" step=".01"
                                       class="form-control m-input m-input--pill m-input--air"
                                       placeholder="{{trans('fields.refunded_price')}}"
                                       required name="refunded_price" value="@old('refunded_price',0)"
                                       id="refunded_price">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span><i class="fa fa-dollar-sign"></i></span>
                                </span>
                            </div>
                            @show_error('refunded_price')
                        </div>
                        <div class="form-group m-form__group">
                            <label for="transaction_number">رقم الحوالة</label>
                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                <input type="number" step=".01"
                                       class="form-control m-input m-input--pill m-input--air"
                                       placeholder="رقم الحوالة"
                                       required name="transaction_number" value="@old('transaction_number',0)"
                                       id="transaction_number">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span><i class="fa fa-dollar-sign"></i></span>
                                </span>
                            </div>
                            @show_error('refunded_price')
                        </div>
                        <div class="form-group m-form__group">
                            <label for="transaction_image">صورة الحوالة</label>
                            @component('components.upload_image_create',['name'=>'transaction_image','name1'=>'def_image','text'=>'none'])
                            @endcomponent
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom"
                                data-dismiss="modal">اغلاق
                        </button>
                        <button type="submit"
                                class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">تأكيد
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <div id="choose_driver_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اختر مندوب التوصيل للطلب</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form id="choose_driver_form" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="driver_order_id" name="order_id" value="{{ $out->id }}">
                        <div class="form-group m-form__group">
                                <label for="driver_id">مندوب التوصيل</label>
                                <select name="driver_id" search="true" id="driver_id">
                                    @foreach($drivers as $driver)
                                        <option value="{{$driver->id}}">{{$driver->name}}</option>
                                    @endforeach

                                </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom"
                                data-dismiss="modal">اغلاق
                        </button>
                        <button type="submit"
                                class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">تأكيد
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('plugins')

@endsection

@section('scripts')

@endsection

@section('custom_scripts')
    <script>
        $(function () {
            $('.btn-action-0').click(function () {

// var paid = $(this).attr('data-paid');
                swal(
                    {
                        title:"هل انت متأكد ؟",
                        text:"هل تريد بالتأكيد تأكيد الطلب",
                        type:"warning",
                        showCancelButton:1,
                        confirmButtonText:"نعم , قم بالتغيير !",
                        cancelButtonText:"لا, الغي العملية !",
                        reverseButtons:1
                    }).then(function(e){

                    if(e.value){
                        var token = '<?= csrf_token() ?>';
                        var url = '{{route('system.orders.change_order_status_to_one')}}';
                        var order = <?= $out->id?>;
                        $.post(url,
                            {
                                _token: token,
                                id: order
                            },
                            function (data, status) {
                                if (data.done == true) {
                                    {{--if(paid == 'not-paid'){--}}
                                    {{--window.location.href="{{ route('system.orders.index') }}";--}}
                                    {{--}else{--}}
                                        location.reload();
                                    // }

                                } else {
                                    alert('هناك خطأ ما');
                                }
                            });

                    }else{
                        e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                    }
                });


            });
            $('#choose_driver_form').submit(function (e) {
                e.preventDefault();
                swal(
                    {
                        title:"هل انت متأكد ؟",
                        text:"هل تريد بالتأكيد بدء الذبح",
                        type:"warning",
                        showCancelButton:1,
                        confirmButtonText:"نعم , قم بالتغيير !",
                        cancelButtonText:"لا, الغي العملية !",
                        reverseButtons:1
                    }).then(function(e){

                    if(e.value){
                        var token = '<?= csrf_token() ?>';
                        var url = '{{route('system.orders.change_order_status_to_prepared')}}';
                        var order = <?= $out->id?>;
                        var driver_id = $('#driver_id').val();
                        $.post(url,
                            {
                                _token: token,
                                id: order,
                                driver_id: driver_id
                            },
                            function (data, status) {
                                if (data.done == true) {
                                    location.reload();
                                } else {
                                    swal(data.msg,data.msg,"error")
                                }
                            });

                    }else{
                        e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                    }
                });


            });
            $('.btn-action-1').click(function () {


                swal(
                    {
                        title:"هل انت متأكد ؟",
                        text:"هل تريد بالتأكيد بدء توصيل الطلب",
                        type:"warning",
                        showCancelButton:1,
                        confirmButtonText:"نعم , قم بالتغيير !",
                        cancelButtonText:"لا, الغي العملية !",
                        reverseButtons:1
                    }).then(function(e){

                    if(e.value){
                        var token = '<?= csrf_token() ?>';
                        var url = '{{route('system.orders.change_order_status_to_tow')}}';
                        var order = <?= $out->id?>;
                        $.post(url,
                            {
                                _token: token,
                                id: order
                            },
                            function (data, status) {
                                if (data.done == true) {
                                    location.reload();
                                } else {
                                    alert('هناك خطأ ما');
                                }
                            });

                    }else{
                        e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                    }
                });


            });
            $('.btn-action-2').click(function () {


                swal(
                    {
                        title:"هل انت متأكد ؟",
                        text:"هل تريد بالتأكيد تسليم الطلب",
                        type:"warning",
                        showCancelButton:1,
                        confirmButtonText:"نعم , قم بالتغيير !",
                        cancelButtonText:"لا, الغي العملية !",
                        reverseButtons:1
                    }).then(function(e){

                    if(e.value){
                        var token = '<?= csrf_token() ?>';
                        var url = '{{route('system.orders.change_order_status_to_three')}}';
                        var order = <?= $out->id?>;
                        $.post(url,
                            {
                                _token: token,
                                id: order
                            },
                            function (data, status) {
                                if (data.done == true) {
                                    location.reload();
                                } else {
                                    alert('هناك خطأ ما');
                                }
                            });

                    }else{
                        e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                    }
                });


            });
            $('.btn-action-6').click(function () {

                swal(
                    {
                        title:"هل انت متأكد ؟",
                        text:"هل تريد بالتأكيد الغاء الطلب",
                        type:"warning",
                        showCancelButton:1,
                        confirmButtonText:"نعم , قم بالتغيير !",
                        cancelButtonText:"لا, الغي العملية !",
                        reverseButtons:1
                    }).then(function(e){

                    if(e.value){
                        var token = '<?= csrf_token() ?>';
                        var url = '{{route('system.orders.change_order_status_to_can')}}';
                        var order = <?= $out->id?>;
                        $.post(url,
                            {
                                _token: token,
                                id: order,
                            },
                            function (data, status) {
                                if (data.done == true) {
                                    location.reload();
                                } else {
                                    alert('هناك خطأ ما');
                                }
                            });

                    }else{
                        e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                    }
                });


            });

        })
    </script>
    <script>
        $(document).ready(function (e) {
            $(document).on('click', '.refund-canceled', function (e) {
                $('#refund_order_cost').modal('show');
            });
        })
    </script>
    @if($errors && ($errors->has('refunded_price')||$errors->has('transaction_image')||$errors->has('transaction_number')))
        <script>
            $(document).ready(function (e) {
                $('#refund_order_cost').modal('show');
            })
        </script>
    @endif
    <script>
        function myFunction() {
            window.print();
        }
    </script>
@endsection
