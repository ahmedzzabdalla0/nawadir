@extends('layouts.admin')
@php
    $Disname='تقارير العملاء';
    $icon='fas fa-user-tag';
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

                                    <button class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom" id="btn2" type="button" onclick="myFunction()">
                                        <i class="fa fa-print"></i>
                                        <span>طباعة</span>
                                    </button>
                                </li>
                                
                                <li class="m-portlet__nav-item">

                                    <a class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom" href="?paginate=100000" >
                                        <i class="fa fa-print"></i>
                                        <span>طباعة الكل</span>
                                    </a>
                                </li>
                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
                            <div class="col">
                                <form class="form-inline hide-prnt" >
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <select name="status" class="autoSubmit" id="" >
                                                <option value="-1" {{HELPER::set_if($_GET['status'],-1) == -1?'selected':''}}>بحث حسب الحالة</option>
                                                <option value="0" {{HELPER::set_if($_GET['status'],-1) == 0?'selected':''}}>غير مؤكد</option>
                                                <option value="1" {{HELPER::set_if($_GET['status'],-1) == 1?'selected':''}}>مفعل</option>
                                                <option value="2" {{HELPER::set_if($_GET['status'],-1) == 2?'selected':''}}>معطل</option>
                                                <option value="3" {{HELPER::set_if($_GET['status'],-1) == 3?'selected':''}}>ملغي</option>

                                            </select>
                                        </div>
                                        <div class="input-group input-daterange">
                                            <input type="text" readonly name="date_from" value="{{HELPER::set_if($_GET['date_from'])}}" class="form-control m-input m-input--pill" placeholder="من تاريخ">
                                            <button type="button" class="reset_field"><i class="fa fa-times"></i></button>
                                            <input type="text" readonly name="date_to" value="{{HELPER::set_if($_GET['date_to'])}}" class="form-control m-input m-input--pill" placeholder="الى تاريخ">

                                        </div>
                                        <div class="input-group">
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
                                    <td> بحث حسب تاريخ التسجيل : </td>
                                    <td>
                                        {{HELPER::set_if($_GET['date_from'],'غير موجود')}}
                                    </td>
                                    <td> الى : </td>
                                    <td>
                                        {{HELPER::set_if($_GET['date_to'],'غير موجود')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td> الاسم :</td>
                                    <td>
                                        {{HELPER::set_if($_GET['name'],'-')}}

                                    </td>
                                    <td>بحث حسب الحالة : </td>
                                    <td>
                                        @php
                                            switch(HELPER::set_if($_GET['status'],-1)){
                                                case -1:echo 'غير مدخل';break;
                                                case 0:echo 'غير مؤكد';break;
                                                case 1:echo 'مفعل';break;
                                                case 2:echo 'معطل';break;
                                                case 3:echo 'ملغي';break;
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
                                        <th class="text-right">الاسم</th>
                                        <th>البريد الالكتروني</th>
                                        <th>رقم الجوال</th>
                                        <th>الطلبات</th>
                                        <th>الحالة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">
                                            <td class="LOOPIDS">{{($out ->currentpage()-1) * $out ->perpage() + $loop->iteration}}</td>
                                            <td class="text-right">
                                                <img src="{{$o->image_thumbnail}}" class="img_table" alt="">
                                                {{$o->name}}</td>
                                            <td>{{$o->email??'-'}}</td>
                                            <td>{{$o->mobile}}</td>
                                            <td>{{$o->orders()->count()}}</td>
                                            <td>
                                                @if($o->status == 0)
                                                   غير مؤكد
                                                @elseif($o->status == 1)
                                                    مفعل
                                                @elseif($o->status == 2)
                                                     معطل
                                                @elseif($o->status == 3)
                                                    ملغي
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="hide-prnt">
                                {!! $out->appends($_GET)->links() !!}
                            </div>
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
