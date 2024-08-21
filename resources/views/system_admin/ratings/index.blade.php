@extends('layouts.admin')
@php
    $Disname='ادارة التعليقات';
    $icon='fas fa-comments';
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
                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle btn m-btn--pill m-btn--air btn-outline-warning m-btn m-btn--custom">
                                        <i class="fa fa-cog"></i>
                                        <span>العمليات</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        @cando('activate','rates')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.ratings.accept')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-check"></i>
                                                                <span class="m-nav__link-text">قبول</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.ratings.decline')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-times "></i>
                                                                <span class="m-nav__link-text">رفض</span>
                                                            </a>
                                                        </li>
                                                        @endcando




                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">
                        <div class="row" style="margin-bottom: 1.22rem;margin-top: -.88rem;">
                            <div class="col">
                                <form class="form-inline" style="float: right">
                                    <div class="form-group m-form__group">
                                        <div class="input-group">
                                            <select name="is_rate_notes_approved"class="autoSubmit" id="is_rate_notes_approved" >
                                                <option {{  is_null(request('is_rate_approved')) || request('is_rate_approved') == -1 ?'selected':'selected'}} value="-1">بحث حسب اظهار التقييم</option>
                                                <option {{ !is_null(request('is_rate_approved')) && request('is_rate_approved') == 0?'selected':''}} value="0">قيد المراجعة</option>
                                                <option {{ !is_null(request('is_rate_approved')) && request('is_rate_approved') == 2?'selected':''}} value="2">مرفوض</option>
                                                <option {{  !is_null(request('is_rate_approved')) && request('is_rate_approved') == 1?'selected':''}} value="1">مقبول</option>
                                            </select>
                                        </div>
                                        <div class="input-group input-daterange">
                                            <input type="text" readonly name="date_from" value="{{ request('date_from') }}" class="form-control m-input m-input--pill" placeholder="من تاريخ">
                                            <button type="button" class="reset_field"><i class="fa fa-times"></i></button>
                                            <input type="text" readonly name="date_to" value="{{ request('date_to') }}" class="form-control m-input m-input--pill" placeholder="الى تاريخ">

                                        </div>

                                        <div class="input-group">
                                            <button class=" btn m-btn--pill btn-outline-info m-btn" type="submit"><i class="fa fa-search"></i></button>
                                        </div>

                                    </div>

                                </form>
                            </div>


                        </div>
                        @if(isset($out) && count($out) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr >


                                        <th>#</th>
                                        <th width="5%" style="text-align: center;vertical-align: middle;">
                                            <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                <input type="checkbox" id="SelectAll">
                                                <span></span>
                                            </label>
                                        </th>
                                        <th class="text-center">رقم الطلب</th>
                                        <th class="text-center">المستخدم</th>
                                        <th class="text-center">التكلفة</th>
                                        <th class="text-center">تعليق المستخدم</th>
                                        <th class="text-center">موافقة الادارة</th>
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        @if($o->user && !$o->user->is_deleted)
                                           <tr id="TR_{{$o->id}}" >

                                               <td class="LOOPIDS">{{$loop->iteration}}</td>
                                               <td style="text-align: center;vertical-align: middle;">
                                                   <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                       <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                       <span></span>
                                                   </label>
                                               </td>
                                               <td class="text-center"><a href="{{route('system.orders.details',$o->id)}}" >#{{ $o->id }}</a></td>
                                               <td class="text-center">
                                                   @cando('view','users')
                                                   <a href="{{ route('system.users.details',$o->user->id)}}">{{$o->user->name}}</a>
                                                   @elsecando
                                                   {{$o->user->name}}
                                                   @endcando
                                               </td>

                                               <td class="text-center"> {{$o->total_price.' '.HELPER::set_if($config['currency_ar'])}}</td>
                                               <td class="text-center">
                                                   {{$o->rate_notes??'-'}}
                                               </td>
                                               <td class="text-center">
                                                   @if($o->is_rate_approved == 1)

                                                       <span class="m--font-success"> مقبول </span>
                                                   @elseif($o->is_rate_approved == 2)
                                                       <span class="m--font-danger"> مرفوض </span>
                                                   @else
                                                       <span class="m--font-warning"> قيد المراجعة </span>
                                                   @endif
                                               </td>
                                               <td>

                                                       <a
                                                               href="{{route('system.ratings.show',$o->id)}}"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom  showit"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="اضغط لعرض التفاصيل"

                                                       >
                                                           <i class="fa fa-laptop"></i> التفاصيل </a>

                                               </td>

                                           </tr>
                                           @endif
                                    @endforeach
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
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" >

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تفاصيل التعليق</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                    <div class="modal-body">
                        <h4>التفاصيل : </h4>
                        <p id="body" style="width: 100%;word-wrap: break-word;"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom" data-dismiss="modal">اغلاق</button>
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

    <script>
        $(function () {

            $(".showit").click(function () {
                var n= $('#body').text($(this).data('body'));
            });


        })
    </script>

@endsection
