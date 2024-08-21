@extends('layouts.admin')


@section('head')
    <link href="{{asset('admin/assets/vendors/custom/fullcalendar/fullcalendar.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('page_content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">


        <!-- BEGIN: Subheader -->
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
                            <span  class="m-nav__link">
                                <span class="m-nav__link-text">لوحة التحكم</span>
                            </span>
                        </li>

                    </ul>
                </div>

            </div>
        </div>

        <!-- END: Subheader -->
        <div class="m-content">

{{--            <div class="m-portlet ">--}}
{{--                <div class="m-portlet__body  m-portlet__body--no-padding">--}}
{{--                    --}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row m-row--no-padding m-row--col-separator-xl">
                @cando('view','orders')
                <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                    <a href="{{route('system.orders.mainIndex')}}" style="text-decoration: none;">

                        <div class="card-box bg-blue">
                            <div class="icon">
                                <i class="fas fa-xs fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c5}}</h3>
                                <h4>اجمالي الطلبات</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                    <a href="{{route('system.orders.index')}}">
                        <div class="card-box bg-success">
                            <div class="icon">
                                <i class="fa fa-xs fa-shopping-cart" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c6}}</h3>
                                <h4>الطلبات الجديدة</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                    <a href="{{route('system.orders.index')}}">
                        <div class="card-box bg-warning">
                            <div class="icon">
                                <i class="fa fa-xs fa-cart-arrow-down" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c7}}</h3>
                                <h4>طلبات قيد التجهيز</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                <div class="col-md-12 col-lg-3 col-xl-3" style="padding: 15px;">

                    <a href="{{route('system.orders.canceled')}}">
                        <div class="card-box bg-danger">
                            <div class="icon">
                                <i class="fa fa-xs fa-ban" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c8}}</h3>
                                <h4 style="font-size: 14px;">طلبات ملغية</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                @endcando
                @cando('view','users')
                <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                    <a href="{{route('system.users.index')}}">
                        <div class="card-box bg-success">
                            <div class="icon">
                                <i class="fas fa-xs fa-users" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c1}}</h3>
                                <h4>المستخدمين</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                @endcando

                @cando('view','products')
                <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                    <a href="{{route('system.products.index')}}">
                        <div class="card-box m--bg-focus">
                            <div class="icon">
                                <i class="fas fa-xs fa-shopping-basket" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c3}}</h3>
                                <h4>المنتجات</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                @endcando
                @cando('view','contacts')
                <div class="col-md-12 col-lg-4 col-xl-4" style="padding: 15px;">

                    <a href="{{route('system.contacts.index')}}">
                        <div class="card-box m--bg-brand">
                            <div class="icon">
                                <i class="fa fa-xs fa-comment" aria-hidden="true"></i>
                            </div>
                            <div class="inner">
                                <h3 class="counter">{{$c4}}</h3>
                                <h4>الاستفسارات</h4>
                            </div>
                            <div  class="card-box-footer">عرض المزيد <i class="fa fa-arrow-circle-left"></i></div>
                        </div>
                    </a>

                </div>
                @endcando
            </div>
            <div class="row">
                @cando('view','orders')
                <div class="col-xl-8">

                    <!--begin:: Widgets/Best Sellers-->
                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        اخر الطلبات
                                    </h3>
                                </div>
                            </div>

                        </div>
                        <div class="m-portlet__body">

                            <!--begin::Content-->
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">

                                    <!--begin::m-widget5-->
                                    <div class="m-widget5">
                                        @if(isset($neworders) && count($neworders) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th class="text-center">رقم الطلب</th>
                                                        <th class="text-center">الاسم</th>
                                                        <th class="text-center">المستخدم</th>
                                                        <th class="text-center">السعر الكلي</th>
                                                        <th class="text-center">عدد المنتجات</th>
                                                        <th class="text-center">الحالة</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($neworders as $a)

                                                        <tr id="TR_{{$a->id}}">
                                                            <td class="LOOPIDS order_old">{{$loop->iteration}}</td>
                                                            <td class="text-center">
                                                                <a href="{{route('system.orders.details',$a->id)}}" target="_blank"> <?= $a->id ?></a>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $a->name ?>
                                                            </td>
                                                            <td class="text-center">
                                                                {{@$a->user->name}}
                                                            </td>
                                                            <td class="text-center"><?= $a->total_price ?> {{HELPER::set_if($config['currency'])}}</td>
                                                            <td class="text-center">
                                                                {{$a->products()->count()}}
                                                            </td>

                                                            <td class="text-center" id="STAT_<?= $a->id ?>">
                                                                <span style="color: {{@$a->status->color_hex}}">{{@$a->status->name}}</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="note note-info">
                                                <h4 class="block">لا يوجد بيانات للعرض</h4>
                                            </div>
                                        @endif

                                    </div>

                                    <!--end::m-widget5-->
                                </div>

                            </div>

                            <!--end::Content-->
                        </div>
                    </div>

                    <!--end:: Widgets/Best Sellers-->
                </div>

                <div class="col-xl-4">

                    <!--begin:: Widgets/Top Products-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        الطلبات
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">

                            <!--begin::Widget5-->
                            <div class="m-widget4">
                                <div class="m-widget4__chart m-portlet-fit--sides m--margin-top-10 m--margin-top-20" style="height:260px;">
                                    <canvas id="m_chart_trends_stats"></canvas>
                                </div>
                                @foreach($topProducts as $r)
                                    <div class="m-widget4__item">
                                        <div class="m-widget4__img m-widget4__img--logo">
                                            <img src="{{$r->image_url}}" alt="">
                                        </div>
                                        <div class="m-widget4__info">
													<span class="m-widget4__title">
														{{$r->name}}
													</span><br>
                                        </div>
                                        <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-danger">{{$r->orders_count}} طلب </span>
												</span>
                                    </div>
                                @endforeach
                            </div>

                            <!--end::Widget 5-->
                        </div>
                    </div>

                    <!--end:: Widgets/Top Products-->
                </div>
                @endcando

                @cando('view','products')
                <div class="col-xl-8">

                    <!--begin:: Widgets/Best Sellers-->
                    <div class="m-portlet m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        اخر المنتجات
                                    </h3>
                                </div>
                            </div>

                        </div>
                        <div class="m-portlet__body">

                            <!--begin::Content-->
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">

                                    <!--begin::m-widget5-->
                                    <div class="m-widget5">
                                        @if(isset($newProducts) && count($newProducts) > 0)
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-right">الإسم</th>
                                                        <th class="text-center">التصنيف</th>
                                                        <th class="text-center">السعر</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    @foreach($newProducts as $o)

                                                        <tr id="TR_{{$o->id}}">

                                                            <td class="text-right">
                                                                <img src="{{$o->image_url}}" class="img_table" alt="">
                                                                {{$o->name}}
                                                            </td>
                                                            <td class="text-center"> {{@$o->category->name}}</td>
                                                            <td class="text-center"> @if($o->has_discount) <span class="old_price">{{$o->real_price}}</span>  <span class="new_price">{{$o->price}} {{HELPER::set_if($config['currency_ar'])}}</span>@else {{$o->price}}  {{HELPER::set_if($config['currency_ar'])}}@endif</td>






                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <div class="note note-info">
                                                <h4 class="block">لا يوجد بيانات للعرض</h4>
                                            </div>
                                        @endif

                                    </div>

                                    <!--end::m-widget5-->
                                </div>

                            </div>

                            <!--end::Content-->
                        </div>
                    </div>

                    <!--end:: Widgets/Best Sellers-->
                </div>
                @endcando
                @cando('view','orders')
                <div class="col-xl-4">

                    <!--begin:: Widgets/Authors Profit-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        تقسيم الطلبات
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget14">
                                <div class="row  align-items-center" style="margin-top: 30px;">
                                    <div class="col">
                                        <div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">
                                            <div class="m-widget14__stat">{{$or1+$or2+$or3}}</div>
                                        </div>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col">
                                        <div class="m-widget14__legends" style="margin-top: 30px;">
                                            <div class="m-widget14__legend"style="text-align: center;">
                                                <span class="m-widget14__legend-bullet m--bg-brand"></span>
                                                <span class="m-widget14__legend-text">{{round(($or3 / ($ototal))*100,1)}}% طلبات ملغية</span>
                                            </div>
                                            <div class="m-widget14__legend" style="text-align: center;">
                                                <span class="m-widget14__legend-bullet m--bg-accent"></span>
                                                <span class="m-widget14__legend-text">{{round(($or1 / ($ototal))*100,1)}}% طلبات غير مكتملة</span>
                                            </div>
                                            <div class="m-widget14__legend"style="text-align: center;">
                                                <span class="m-widget14__legend-bullet m--bg-warning"></span>
                                                <span class="m-widget14__legend-text">{{round(($or2 / ($ototal))*100,1)}}% طلبات مكتملة</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end:: Widgets/Authors Profit-->
                </div>


                @endcando
            </div>
            @if($showCalender)
            <div class="row">
                <div class="col-xl-12">

                    <!--begin::Portlet-->
                    <div class="m-portlet " id="m_portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon">
													<i class="flaticon-map-location"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        التقويم
                                    </h3>
                                </div>
                            </div>

                        </div>
                        <div class="m-portlet__body">
                            <div id="m_calendar"></div>
                        </div>
                    </div>

                    <!--end::Portlet-->
                </div>
            </div>
                @endif
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script src="{{asset('admin/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
    <script src="{{asset('admin/assets/vendors/custom/fullcalendar/ar-sa.js')}}" type="text/javascript"></script>
    <script>

        var calendarInit = function() {
            if ($('#m_calendar').length === 0) {
                return;
            }

            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            $('#m_calendar').fullCalendar({
                isRTL: true,
                header: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                editable: false,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                defaultDate: moment('{{\Carbon\Carbon::now()->toDateString()}}'),
                events: [
                        @foreach($orders as $o)
                    {
                        title: '{{$o->nameid}}',
                        start: moment('{{$o->date}} {{$o->time_id}}:00'),
                        description: '{{$o->nameid}}',
                        url: '{{route('system.orders.details',$o->id)}}',
                        className: "m-fc-event--accent"

                    },
                    @endforeach

                ],

                eventRender: function(event, element) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', event.description);
                        element.data('placement', 'top');
                        mApp.initPopover(element);
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + event.description + '</div>');
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + event.description + '</div>');
                    }
                }
            });
        }


        var profitShare = function() {
            if ($('#m_chart_profit_share').length == 0) {
                return;
            }

            var chart = new Chartist.Pie('#m_chart_profit_share', {
                series: [{
                    value: {{round(($or3 / ($ototal))*100,1)}},
                    className: 'custom',
                    meta: {
                        color: mApp.getColor('brand')
                    }
                },
                    {
                        value: {{round(($or1 / ($ototal))*100,1)}},
                        className: 'custom',
                        meta: {
                            color: mApp.getColor('accent')
                        }
                    },
                    {
                        value: {{round(($or2 / ($ototal))*100,1)}},
                        className: 'custom',
                        meta: {
                            color: mApp.getColor('warning')
                        }
                    }
                ],
                labels: [1, 2, 3]
            }, {
                donut: true,
                donutWidth: 17,
                showLabel: false
            });

            chart.on('draw', function(data) {
                if (data.type === 'slice') {
                    // Get the total path length in order to use for dash array animation
                    var pathLength = data.element._node.getTotalLength();

                    // Set a dasharray that matches the path length as prerequisite to animate dashoffset
                    data.element.attr({
                        'stroke-dasharray': pathLength + 'px ' + pathLength + 'px'
                    });

                    // Create animation definition while also assigning an ID to the animation for later sync usage
                    var animationDefinition = {
                        'stroke-dashoffset': {
                            id: 'anim' + data.index,
                            dur: 1000,
                            from: -pathLength + 'px',
                            to: '0px',
                            easing: Chartist.Svg.Easing.easeOutQuint,
                            // We need to use `fill: 'freeze'` otherwise our animation will fall back to initial (not visible)
                            fill: 'freeze',
                            'stroke': data.meta.color
                        }
                    };

                    // If this was not the first slice, we need to time the animation so that it uses the end sync event of the previous animation
                    if (data.index !== 0) {
                        animationDefinition['stroke-dashoffset'].begin = 'anim' + (data.index - 1) + '.end';
                    }

                    // We need to set an initial value before the animation starts as we are not in guided mode which would do that for us

                    data.element.attr({
                        'stroke-dashoffset': -pathLength + 'px',
                        'stroke': data.meta.color
                    });

                    // We can't use guided mode as the animations need to rely on setting begin manually
                    // See http://gionkunz.github.io/chartist-js/api-documentation.html#chartistsvg-function-animate
                    data.element.animate(animationDefinition, false);
                }
            });

            // For the sake of the example we update the chart every time it's created with a delay of 8 seconds
            return;

            /*
            chart.on('created', function() {
                if (window.__anim21278907124) {
                    clearTimeout(window.__anim21278907124);
                    window.__anim21278907124 = null;
                }
                window.__anim21278907124 = setTimeout(chart.update.bind(chart), 15000);
            });
            */
        };
        var trendsStats = function() {
            if ($('#m_chart_trends_stats').length == 0) {
                return;
            }

            var ctx = document.getElementById("m_chart_trends_stats").getContext("2d");

            var gradient = ctx.createLinearGradient(0, 0, 0, 240);
            gradient.addColorStop(0, Chart.helpers.color('#00dc8d').alpha(0.7).rgbString());
            gradient.addColorStop(1, Chart.helpers.color('#ecfff4').alpha(0).rgbString());

            var config = {
                type: 'line',
                data: {
                    labels: {!!  json_encode($MonthName)!!},
                    datasets: [{
                        label: "عدد الطلبات الكلي",
                        fill:true,
                        backgroundColor: gradient, // Put the gradient here as a fill color
                        borderColor: '#00dc8d',

                        pointBackgroundColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                        pointBorderColor: Chart.helpers.color('#ffffff').alpha(0).rgbString(),
                        pointHoverBackgroundColor: mApp.getColor('danger'),
                        pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.2).rgbString(),

                        data: {{json_encode($ordercount)}}
                    }]
                },
                options: {
                    responsive:true,
                    title: {
                        display: false,
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            display: false,
                            gridLines: false,
                            scaleLabel: {
                                display: true,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: false,
                            gridLines: false,
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            },
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }

                }
            };

            var chart = new Chart(ctx, config);
        };


        //== Class initialization on page load
        jQuery(document).ready(function() {
            profitShare();
            trendsStats();
            calendarInit();
        });
    </script>
    <script src="{{asset('admin/counter-up/jquery.counterup.js')}}" type="text/javascript"></script>
    <script>
        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        });
    </script>
@endsection
