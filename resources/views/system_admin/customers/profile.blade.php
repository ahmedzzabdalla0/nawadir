@extends('layouts.admin')

@php
    $Disname='الزبائن';
@endphp
@section('title',  $Disname)

@section('head')
    <link href="{{asset('metronic/global/plugins/bootstrap-select/css/bootstrap-select-rtl.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('metronic/pages/css/profile-rtl.min.css')}}" rel="stylesheet"
          type="text/css"/>

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
                        <a href="{{route('system.users.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">التفاصيل</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>



    <div class="m-content">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="m-portlet m-portlet--full-height  ">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                بيانات العميل
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="{{$out->image_thumbnail}}" style="height: 130px;width: 130px;" alt="" />
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name">{{$out->name}}</span>
                                <p class="m-card-profile__email m-link">{{$out->email}}</p>
                                <p class="m-card-profile__email m-link">{{$out->mobile}}</p>
                            </div>
                            @cando('add','notifications')
                            <div class="m-card-profile__details">
                                <a href="{{route('system.notifications.send_per_user',['id'=>$out->id])}}"
                                   style="margin: 3px;width: 100%;"
                                   class="btn btn-outline-primary m-btn m-btn--custom"
                                >ارسال اشعار
                                </a>
                            </div>
                            @endcando
                        </div>

                        <div class="m-portlet__body-separator"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab">
                                        <i class="flaticon-share m--hide"></i>
                                        طلبات المستخدم
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab">
                                        اشعارات المستخدم
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane active" id="m_user_profile_tab_1">
                            <div class="container" style="margin-top: 20px">
                                @if(isset($out->orders) && count($out->orders) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">رقم الطلب</th>
                                                <th class="text-center">السعر الكلي</th>
                                                <th class="text-center">تاريخ الطلب</th>
                                                <th class="text-center">الحالة</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach($out->orders as $a)

                                                <tr id="TR_{{$a->id}}">
                                                    <td class="LOOPIDS order_old">{{$loop->iteration}}</td>
                                                    <td class="text-center">
                                                        <a href="{{route('system.orders.details',$a->id)}}" target="_blank"> <?= $a->id ?></a>
                                                    </td>
                                                    <td class="text-center"><?= $a->total_price ?> {{HELPER::set_if($config['currency'])}}</td>

                                                    <td class="text-center"><?= $a->created_at->toDateString() ?></td>
                                                    <td class="text-center" id="STAT_<?= $a->id ?>">
                                                        <span style="color: {{@$a->case->case->color_hex}}">{{@$a->status->name}}</span>
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


                        </div>
                        <div class="tab-pane " id="m_user_profile_tab_2">
                            <div class="container" style="margin-top: 20px">

                            @if(isset($out->notifies) && count($out->notifies) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="text-center">العنوان</th>
                                            <th class="text-center">النص</th>
                                            <th class="text-center">الحالة</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($out->notifies()->orderBy('id','DESC')->get() as $a)

                                            <tr id="TR_{{$a->id}}">
                                                <td class="LOOPIDS order_old">{{$loop->iteration}}</td>

                                                <td class="text-center">{{$a->title}}</td>
                                                <td class="text-center">{{$a->message}}</td>
                                                <td class="text-center">{{$a->is_seen == 1?'تمت المشاهدة':'جديد'}}</td>
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
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('custom_scripts')

@endsection


