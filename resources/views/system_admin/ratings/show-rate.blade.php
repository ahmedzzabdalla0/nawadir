@extends('layouts.admin')

@php
    $Disname='ادارة التعليقات';
     $icon='fas fa-comments';
@endphp
@section('title',  $Disname)

@section('head')
    <link href="{{asset('metronic/global/plugins/bootstrap-select/css/bootstrap-select-rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic/pages/css/profile-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>
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
                        <a href="{{route('system.ratings.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">#{{$out->id}}</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>



    <div class="m-content">
        <div class="row">
            <div class="col-xl-3 col-lg-4 hide-prnt">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title">
                                بيانات المستخدم
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="{{$out->user->image_thumbnail}}" style="height: 130px;width: 130px;"
                                         alt=""/>
                                </div>
                            </div>
                            <div class="m-card-profile__details">


                                <p class="m-card-profile__email" style="display: block;font-weight: bold;">
                                <div class="btn-group" role="group">
                                    <button id="choices" type="button" class="btn btn-success dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        خيارات
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="choices">
                                        @cando('view','users')
                                        <a href="{{route('system.users.details',$out->user->id)}}"
                                           class="dropdown-item"
                                        >
                                            عرض المستخدم
                                        </a>
                                        @endcando
                                    </div>
                                </div>

                                </p>
                                <p class="m-card-profile__email m-link" style="display: block;font-weight: bold;">
                                    <span>الاسم:</span>
                                    <br>
                                    {{$out->user->name}}
                                </p>

                            </div>
                        </div>

                        <div class="m-portlet__body-separator"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs ">
                    <div class="m-portlet__head  hide-prnt">
                        <div class="m-portlet__head-caption hide-prnt">
                            <div class="m-portlet__head-title hide-prnt">
                                <h3 class="m-portlet__head-text">
                                    بيانات الطلب
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools hide-prnt">
                            <ul class="m-portlet__nav">
                                <li class="m-portlet__nav-item">

                                    <button class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom"
                                            id="btn2" type="button" onclick="myFunction()">
                                        <i class="fa fa-print"></i>
                                        <span>طباعة</span>
                                    </button>
                                </li>
                                @cando('activate','rates')
                                @if(!$out->is_rate_approved)
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        m-dropdown-toggle="hover">
                                        <div>
                                            <a href="#"
                                               class="m-portlet__nav-link m-dropdown__toggle btn m-btn--pill m-btn--air btn-outline-warning m-btn m-btn--custom">
                                                <i class="fa fa-cog"></i>
                                                <span>العمليات</span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav">
                                                                <li class="m-nav__item">
                                                                    <a href="javascript:;" class="m-nav__link btn-doAction"
                                                                       data-url="{{route('system.ratings.accept')}}"
                                                                       data-token="<?= csrf_token() ?>"
                                                                       data-id="<?= $out->id ?>"
                                                                    >
                                                                        <i class="m-nav__link-icon fa fa-check"></i>
                                                                        <span class="m-nav__link-text">قبول</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="javascript:;" class="m-nav__link btn-doAction"
                                                                       data-url="{{route('system.ratings.decline')}}"
                                                                       data-token="<?= csrf_token() ?>"
                                                                       data-id="<?= $out->id ?>"
                                                                    >
                                                                        <i class="m-nav__link-icon fa fa-times "></i>
                                                                        <span class="m-nav__link-text">رفض</span>
                                                                    </a>
                                                                </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                @endcando
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_project_details_tab_1">
                            <div class="container" style="margin-top: 20px">
                                <div class="form-group m-form__group">
                                    <label style="font-weight: bold;">التقييم:</label>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <tr>
                                                <td>تاريخ التقييم</td>
                                                <td>{{$out->rated_at ? \Carbon\Carbon::parse($out->rated_at)->format('Y/m/d, h:i a'):'-'}}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <hr class="hide-prnt">
                                <?php
                                $productssum = 0;
                                ?>
                                @if($out->products()->count())
                                    <div class="form-group m-form__group">
                                        <label style="text-align: center;margin-top: 20px;">منتجات الطلب</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-condensed" style="text-align: center;margin-bottom: 15px;">
                                                <thead>
                                                <tr>
                                                    <th style="text-align: center">#</th>
                                                    <th style="text-align: center">اسم المنتج</th>
                                                    <th style="text-align: center">السعر</th>
                                                    <th style="text-align: center">التعليق</th>
                                                    <th style="text-align: center">التقييم</th>

                                                </tr>

                                                </thead>
                                                <tbody>
                                                <?php $i = 1;
                                                foreach ($out->products as $a) { ?>
                                                <tr>
                                                    <td><?= $i ?></td>
                                                    <td>
                                                        <?= $a->productVariant->name ?>
                                                    </td>
                                                    <td>
                                                        <?= $a->price ?> {{HELPER::set_if($config['currency_ar'])}}
                                                        <?php $productssum += $a->price; ?>
                                                    </td>
                                                    <td>
                                                        {{$a->rate_notes??'-'}}
                                                    </td>
                                                    <td>
                                                        <p style="margin: auto;color:#FFD119;font-size: 20px;"
                                                           class="rating"
                                                           data-rate-value={{ $a->rate??0 }}></p>
                                                    </td>
                                                </tr>
                                                <?php $i++;
                                                } ?>

                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                @endif

                                <div class="clearfix"></div>
                                <div class="clearfix"></div>
                                <div class="w-100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.6/highlight.min.js"></script>
    <script src="{{ asset('js/rater/rater.min.js') }}"></script>
    <script>
        function myFunction() {
            window.print();
        }
    </script>
    <script>
        hljs.initHighlightingOnLoad();
        $(document).ready(function () {
            var options = {
                max_value: 5,
                step_size: 0.25,
                readonly: true,

            };
            $(".rating").rate(options);
        });
    </script>
@endsection

