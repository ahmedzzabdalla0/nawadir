<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

    <!-- START HEADER/BANNER -->

    <tbody>
    <tr>
        <td align="center">
            <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td align="center" valign="top" bgcolor="#141414"
                        style="background-size:cover; background-position:top;"
                        height="200">
                    <table class="col-600" width="600" height="250" border="0" align="center" cellpadding="0"
                           cellspacing="0">

                        <tbody>
                        <tr>
                            <td height="40"></td>
                        </tr>


                        <tr>
                            <td align="center" style="line-height: 0px;">
                                <a style="text-decoration: none;color:#fff;
                                            font-size: 50px;font-weight: bolder;"
                                   href="{{ config('app.url') }}">
                                    {{ strtoupper(config('app.name')) }}
                                </a>
                            </td>
                        </tr>


                        <tr>
                            <td align="center"
                                style="font-family: 'Raleway', sans-serif; font-size:30px; color:#ffffff; line-height:15px; font-weight: bold;">
                                تحديث على حالة الطلب
                            </td>
                        </tr>
                        <tr>
                            <td height="50"></td>
                        </tr>
                        </tbody>
                    </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <!-- END HEADER/BANNER -->


    <!-- START 3 BOX SHOWCASE -->

    <tr>
        <td align="center">
            <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0"
                   style="margin-left:20px; margin-right:20px; border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
                <tbody>
                <tr>
                    <td height="35"></td>
                </tr>

                <tr>
                    <td align="center"
                        style="font-family: 'Raleway', sans-serif; font-size:22px; font-weight: bold; color:#2a3a4b;">{{ $text }}
                    </td>
                </tr>

                <tr>
                    <td height="10"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td align="center">
            <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0"
                   style="border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9; ">
                <tbody>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td>


                        <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td height="30"></td>
                            </tr>
                            <tr>
                                <table dir="rtl" style="border: 1px solid #dbd9d9;text-align: center;width: 100%;margin-left: auto;color: #2a3a4b;">
                                    <thead style="border: 1px solid #dbd9d9;">
                                    <tr>
                                        <th style="border: 1px solid #dbd9d9;">المنتج</th>
                                        <th style="border: 1px solid #dbd9d9;">الكمية</th>
                                        <th style="border: 1px solid #dbd9d9;">سعر المنتج</th>
                                        <th style="border: 1px solid #dbd9d9;">السعر في الطلب</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->products as $product)
                                        <tr>
                                            <td style="border: 1px solid #dbd9d9;">{{$product->productVariant->name}}</td>
                                            <td style="border: 1px solid #dbd9d9;">{{$product->qty}}</td>
                                            <td style="border: 1px solid #dbd9d9;">{{$product->productVariant->end_price  .' '.$config['currency_ar']}}</td>
                                            <td style="border: 1px solid #dbd9d9;">{{$product->price .' '.$config['currency_ar']}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" style="border: 1px solid #dbd9d9;">سعر التوصيل</td>
                                        <td style="border: 1px solid #dbd9d9;">{{($order->delivery_price) .' '.$config['currency_ar']}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="border: 1px solid #dbd9d9;">السعر الاجمالي</td>
                                        <td style="border: 1px solid #dbd9d9;">{{$order->total_price .' '.$config['currency_ar']}}</td>
                                    </tr>
                                    @if($order->case->case_id == 6 && $order->is_canceled_refunded)
                                        <tr>
                                            <td colspan="3" style="border: 1px solid #dbd9d9;">المبلغ المسترجع</td>
                                            <td style="border: 1px solid #dbd9d9;">{{$order->refunded_amount .' '.$config['currency_ar']}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="border: 1px solid #dbd9d9;">رقم الحوالة</td>
                                            <td style="border: 1px solid #dbd9d9;">{{$order->transaction_number}}</td>
                                        </tr>
                                    @endif

                                    </tbody>
                                </table>


                            </tr>
                            <tr>
                                <td height="30"></td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <tr>
        <td height="5"></td>
    </tr>


    <tr>
        <td align="center">
            <table class="col-600" width="600" border="0" align="center" cellpadding="0" cellspacing="0"
                   style="margin-left:20px; margin-right:20px;">

                <tbody>

                <tr>
                    <td align="center">
                        <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0"
                               style=" border-left: 1px solid #dbd9d9; border-right: 1px solid #dbd9d9;">
                            <tbody>
                            <tr>
                                <td height="50"></td>
                            </tr>
                            <tr>
                                <td align="center" bgcolor="0B1026"
                                    height="185">
                                    <table class="col-600" width="600" border="0" align="center" cellpadding="0"
                                           cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td height="25"></td>
                                        </tr>

                                        <tr>
                                            <td align="center"
                                                style="font-family: 'Raleway',  sans-serif; font-size:14px;  color:#fff;">
                                                <span>جميع الحقوق محفوظة.</span>
                                                <br>
                                                {{ config('app.name') }}© {{ date('Y') }}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>

    <!-- END FOOTER -->


    </tbody>
</table>
