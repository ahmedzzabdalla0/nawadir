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
{{--    <div class="rightCont">--}}

{{--        <img src="{{@$a->user->image_thumbnail}}" class="img_table" alt="">--}}
{{--        <div class="price"><?= $a->total_price ?> {{HELPER::set_if($config['currency_ar'])}}</div>--}}

{{--    </div>--}}
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
               class="btn btn-sm  btn-outline-info m-btn m-btn--custom"
               style="width: 100%!important;margin: 3px 0px;"
               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عرض التفاصيل"
            >
                <i class="fa fa-desktop"></i> عرض </a>
            @if(in_array($a->case_id,[1,2]) )

                <button type="button"
                        data-id="{{$a->id}}"
                        data-url="{{route('system.orders.delete')}}"
                        data-token="{{csrf_token()}}"
                        data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"
                        class="btn btn-sm btn-outline-danger m-btn m-btn--custom btn-del"
                        style="width: 100%!important;margin: 3px 0px;">
                    <i class="fa fa-trash "></i>
                    حذف
                </button>

            @endif
        </div>

    </div>




</div>
