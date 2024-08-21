@extends('layouts.admin')
@php
    $Disname='تقارير المنتجات';
    $icon='fas fa-chart-bar';
@endphp
@section('title', $Disname)

@section('head')
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
            .page-breadcrumb{
                display: none;
            }
            .m-body {
                background-color: #fff !important;
            }
            #btn1, #btn2 { display: none !important; }
            a
            {
                display: none;
            }
            .m-footer
            {
                display: none !important;
            }
            .hide-prnt
            {
                display: none !important;
            }
            .rep_a{
                display: block !important;
                margin-bottom: 20px;
            }
            #pp{
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
        .rep_a{
            display: none;
        }
        .col-sm-3,.col-sm-5,.col-sm-4,.col-sm-1,.col-sm-11
        {
            padding: 2px;
        }


        .table_print{
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
                        <a href="{{route('system.reports.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">التقارير</span>
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
                        <div class="m-portlet__head-caption hide-prnt">
                            <div class="m-portlet__head-title hide-prnt">
                                            <span class="m-portlet__head-icon">
                                                <i class="{{$icon}}"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools hide-prnt">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">

                                    <button class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom" id="btn2" type="button" onclick="myFunction()">
                                        <i class="fa fa-print"></i>
                                        <span>طباعة</span>
                                    </button>
                                </li>
                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
                            <div class="col">
                                <form class="form-inline hide-prnt" style="float: right">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <select name="status" class="autoSubmit" id="" >
                                                <option value="-1" {{HELPER::set_if($_GET['status'],-1) == -1?'selected':''}}>بحث حسب الحالة</option>
                                                <option value="1" {{HELPER::set_if($_GET['status'],-1) == 1?'selected':''}}>مفعل</option>
                                                <option value="2" {{HELPER::set_if($_GET['status'],-1) == 2?'selected':''}}>معطل</option>

                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <select name="category_id" class="autoSubmit" search="true" id="category_id" >
                                                <option value="-1" {{HELPER::set_if($_GET['category_id'],-1) == -1?'selected':''}}>بحث حسب التصنيف </option>
                                                @foreach($categories as $r)
                                                    <option value="{{$r->id}}" {{HELPER::set_if($_GET['category_id']) == $r->id?'selected':''}}>{{$r->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="input-group">
                                            <select name="size_id" class="autoSubmit" search="true" id="size_id" >
                                                <option value="-1" {{HELPER::set_if($_GET['size_id'],-1) == -1?'selected':''}}>بحث حسب حجم الحاشي </option>
                                                @foreach($sizes as $r)
                                                    <option value="{{$r->id}}" {{HELPER::set_if($_GET['size_id']) == $r->id?'selected':''}}>{{$r->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                            <div class="input-group" style="display: none;">
                                                <select name="size_id" class="autoSubmit" search="true" id="size_id" >
                                                    <option value="-1" {{HELPER::set_if($_GET['size_id'],-1) == -1?'selected':''}}>بحث حسب الحجم </option>
                                                    @foreach($sizes as $r)
                                                        <option value="{{$r->id}}" {{HELPER::set_if($_GET['size_id']) == $r->id?'selected':''}}>{{$r->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>


                                        <div class="input-group input-daterange ">
                                            <input type="text" readonly name="date_from" value="{{HELPER::set_if($_GET['date_from'])}}" class="form-control m-input m-input--pill" placeholder="من تاريخ">
                                            <button type="button" class="reset_field"><i class="fa fa-times"></i></button>

                                            <input type="text" readonly name="date_to" value="{{HELPER::set_if($_GET['date_to'])}}" class="form-control m-input m-input--pill" placeholder="الى تاريخ">

                                        </div>
                                        <div class="w-100"></div>
                                        <div class="input-group ">
                                            <input type="text" name="price_from" value="{{HELPER::set_if($_GET['price_from'])}}" class="form-control m-input m-input--pill" placeholder="من سعر">
                                            <input type="text" name="price_to" value="{{HELPER::set_if($_GET['price_to'])}}" class="form-control m-input m-input--pill" placeholder="الى سعر">

                                        </div>
                                        <div class="input-group ">
                                            <input type="number" name="min_weight" value="{{HELPER::set_if($_GET['min_weight'])}}" class="form-control m-input m-input--pill" placeholder="من وزن">
                                            <input type="number" name="max_weight" value="{{HELPER::set_if($_GET['max_weight'])}}" class="form-control m-input m-input--pill" placeholder="الى وزن">

                                        </div>
                                        <div class="input-group ">
                                            <input type="text" name="name"  value="{{HELPER::set_if($_GET['name'])}}" class="form-control m-input m-input--pill" placeholder="الاسم">
                                            <div class="input-group-append">
                                                <button class=" btn m-btn--pill btn-outline-info m-btn" type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>


                        </div>


                        <div class="rep_a">
                            <table class="table_print">
                                <tr>
                                    <td colspan="4" style="text-align: center">تفاصيل التقرير</td>

                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: center"></td>

                                </tr>
                                <tr>
                                    <td> حسب التاريخ من : </td>
                                    <td>
                                        {{HELPER::set_if($_GET['date_from'],'لا يوجد')}}
                                    </td>
                                    <td> حسب التاريخ الى : </td>
                                    <td>
                                        {{HELPER::set_if($_GET['date_to'],'لا يوجد')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td> حسب التصنيف : </td>
                                    <td>
                                        @if(HELPER::set_if($_GET['category_id'],-1) != 0)
                                            {{\App\Models\Category::find($_GET['category_id'])?\App\Models\Category::find($_GET['category_id'])->name:'غير مدخل'}}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td> حسب السعر  : </td>
                                    <td>
                                        <span>من : </span>
                                        <span>{{HELPER::set_if($_GET['price_from'],'لا يوجد')}}</span>
                                        <br>
                                        <span>الى : </span>
                                        <span>{{HELPER::set_if($_GET['price_to'],'لا يوجد')}}</span>

                                    </td>
                                </tr>
                                <tr>
                                    <td> حسب الاسم :</td>
                                    <td>
                                        {{HELPER::set_if($_GET['name'])}}

                                    </td>
                                    <td>حسب الحالة : </td>
                                    <td>
                                        @php
                                            switch(HELPER::set_if($_GET['status'],-1)){
                                                case -1:echo 'غير مدخل';break;
                                                case 1:echo 'مفعل';break;
                                                case 2:echo 'معطل';break;
                                            }
                                        @endphp
                                    </td>
                                </tr>
                            </table>
                        </div>


                        @if(isset($out) && count($out) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr >
                                        <th>#</th>
                                        <th class="text-right">الإسم</th>
                                        <th class="text-center">التصنيف</th>
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">تاريخ التسجيل</th>
                                        <th class="text-center">مرات الطلب</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">
                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td class="text-right">
                                                <img src="{{$o->image_thumbnail}}" class="img_table" alt="">
                                                {{$o->name}}
                                            </td>
                                            <td class="text-center"> {{@$o->category->name}}</td>
                                            <td class="text-center"> @if($o->has_discount) <span class="old_price">{{$o->real_price}}</span>  <span class="new_price">{{$o->price}} {{HELPER::set_if($config['currency_ar'])}}</span>@else {{$o->price}}  {{HELPER::set_if($config['currency_ar'])}}@endif</td>

                                            <td class="text-center">
                                                @if($o->status == 1)
                                                    <span class="m--font-success"> مفعل </span>
                                                @elseif($o->status == 2)
                                                    <span class="m--font-danger"> محظور </span>
                                                @elseif($o->status == 0)
                                                    <span class="m--font-warning"> غير مؤكد </span>

                                                @else
                                                    <span class="m--font-warning"> مجهول </span>
                                                @endif
                                            </td>
                                            <td class="text-center"> {{@$o->created_at->toDateString()}}</td>
                                            <td>{{$o->orders()->count()}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {!! $out->appends($_GET)->links() !!}
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
        function myFunction() {
            window.print();
        }
    </script>
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
