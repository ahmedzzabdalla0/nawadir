@extends('layouts.admin')

@php
    $Disname='الاعدادات';
@endphp
@section('title',  $Disname)
@section('head')

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
                <div class="m-portlet  m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                            <span class="m-portlet__head-icon">
                                                <i class="flaticon-cogwheel"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--right m-tabs-line-danger"
                                role="tablist">
                                <li class="nav-item m-tabs__item ">
                                    <a class="nav-link m-tabs__link {{!in_array(Route::current()->parameter('type'),['banks','contact_settings']) ?'active':''}} "  href="{{route('system.settings.index')}}">
                                        اعدادات التطبيق
                                    </a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link {{Route::current()->parameter('type') == 'contact_settings' ?'active':''}} "  href="{{route('system.settings.index',['type'=>'contact_settings'])}}">
                                        اعدادات التواصل
                                    </a>

                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="m-portlet__body">

                        <form action="{{route('system.settings.add')}}" method="post" id="form" >

                            @csrf

                            <div class="tab-content">

                                <div class="tab-pane {{is_null(Route::current()->parameter('type'))||!in_array(Route::current()->parameter('type'),['banks','contact_settings']) ?'active':''}}" id="tab1" role="tabpanel">

                                    <div class="row">
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'currency_ar','data'=>HELPER::set_if($page['currency_ar']),'text'=>'العملة ','placeholder'=>'ادخل العملة','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'currency_en','data'=>HELPER::set_if($page['currency_en']),'text'=>'Currency in English','placeholder'=>'Enter currency','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'ios','data'=>HELPER::set_if($page['ios']),'text'=>'رابط التطبيق ايفون ','icon'=>'fa-globe'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'android','data'=>HELPER::set_if($page['android']),'text'=>'رابط التطبيق اندرويد','icon'=>'fa-globe'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'bank_name','data'=>HELPER::set_if($page['bank_name']),'text'=>'اسم البنك','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'iban','data'=>HELPER::set_if($page['iban']),'text'=>'اي بان','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                         <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'tax','data'=>HELPER::set_if($page['tax']),'text'=>'نسبة الضريبة','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'tax_number','data'=>HELPER::set_if($page['tax_number']),'text'=>' الرقم الضريبي','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                              <div class="col-md-6">
                                            @component('components.input',['name'=>'order_phone','data'=>HELPER::set_if($page['order_phone']),'text'=>'  رقم جوال لتنبيهات الطلبات الجديده','icon'=>'fa-phone'])
                                            @endcomponent
                                        </div>
                                        
                                              <div class="col-md-6">
                                            @component('components.input',['name'=>'order_phone2','data'=>HELPER::set_if($page['order_phone2']),'text'=>'  رقم جوال لتنبيهات الطلبات الجديده (2)','icon'=>'fa-phone'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>
{{--                                        <div class="col-md-6">--}}
{{--                                            @component('components.input',['name'=>'tax_number','data'=>HELPER::set_if($page['tax_number']),'text'=>'الرقم الضريبي','icon'=>'fa-dollar-sign'])--}}
{{--                                            @endcomponent--}}
{{--                                        </div>--}}
                                        <div class="col-md-6">
                                            @component('components.input',['type'=>'number','min'=>1,'name'=>'slaughter_cost','data'=>HELPER::set_if($page['slaughter_cost']),'text'=>'تكلفة الذبح','icon'=>'fa-dollar'])
                                            @endcomponent
                                        </div>
{{--                                        <div class="w-100"></div>--}}
                                        <div class="col-md-6">
                                            <div class="row form-group m-form__group" style="margin-top: 25px;">
                                                <div class="col-md-2">
                                                          <span class="m-switch m-switch--icon">
                                                        <label>
                                                            <input type="checkbox" id="cut_types_activation" name="cut_types_activation"
                                                                   value="1" {{$page['cut_types_activation']==1?'checked="checked"':''}}>
                                                            <span></span>
                                                        </label>
                                                    </span>
                                                </div>
                                                <div class="col-md-7" style="font-weight: bold;padding-top: 8px;">
                                                    تفعيل خيارات الذبح
                                                </div>
                                            </div>
                                        </div>

                                        @if(false && $page['delivery_price_type'] == 2)
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'delivery_price','data'=>HELPER::set_if($page['delivery_price']),'text'=>'سعر التوصيل','icon'=>'fa-dollar-sign'])
                                            @endcomponent
                                        </div>
                                        @endif

                                    </div>
                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="col">
                                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                            <i class="fa fa-check"></i>
                                            <span>تعديل</span>
                                        </button>
                                        <a href="{{route('system_admin.dashboard')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                            <i class="flaticon-cancel"></i>
                                            <span>الغاء</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="tab-pane {{Route::current()->parameter('type') == 'contact_settings' ?'active':''}}" id="tab2" role="tabpanel">

                                    <div class="row">
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'mobile','data'=>HELPER::set_if($page['mobile']),'text'=>'جوال','placeholder'=>'ادخل جوال','icon'=>'fa-phone'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'email','data'=>HELPER::set_if($page['email']),'text'=>'ايميل','placeholder'=>'ادخل الايميل','icon'=>'fa-envelope'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'whatsapp','data'=>HELPER::set_if($page['whatsapp']),'text'=>'whatsapp','icon'=>'fa-phone'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'address','data'=>HELPER::set_if($page['address']),'text'=>'العنوان','placeholder'=>'ادخل العنوان','icon'=>'fa-map'])
                                            @endcomponent
                                        </div>
{{--                                        <div class="w-100"></div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            @component('components.input',['name'=>'facebook','data'=>HELPER::set_if($page['facebook']),'text'=>'فيس بوك','icon_pre'=>'fab ','icon'=>'fa-facebook'])--}}
{{--                                            @endcomponent--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            @component('components.input',['name'=>'twitter','data'=>HELPER::set_if($page['twitter']),'text'=>'رابط تويتر','placeholder'=>'ادخل رابط تويتر','icon_pre'=>'fab ','icon'=>'fa-twitter'])--}}
{{--                                            @endcomponent--}}
{{--                                        </div>--}}
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'snapchat','data'=>HELPER::set_if($page['snapchat']),'text'=>'رابط سناب شات','icon_pre'=>'fab ','icon'=>'fa-snapchat'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.input',['name'=>'instagram','data'=>HELPER::set_if($page['instagram']),'text'=>'رابط انستقرام','placeholder'=>'ادخل رابط انستقرام','icon_pre'=>'fab ','icon'=>'fa-instagram'])
                                            @endcomponent
                                        </div>
                                         <div class="col-md-6">
                                            @component('components.input',['name'=>'facebook','data'=>HELPER::set_if($page['facebook']),'text'=>'رابط  نك توك','placeholder'=>'ادخل رابط تك توك','icon_pre'=>'fab ','icon'=>'fa-tiktok'])
                                            @endcomponent
                                        </div>
                                              <div class="col-md-6">
                                            @component('components.input',['name'=>'twitter','data'=>HELPER::set_if($page['twitter']),'text'=>'رابط  تويتر','placeholder'=>'ادخل رابط تويتر ','icon_pre'=>'fab ','icon'=>'fa-twitter'])
                                            @endcomponent
                                        </div>
                                        <div class="w-100"></div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <br>

                                    <div class="col">
                                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                            <i class="fa fa-check"></i>
                                            <span>تعديل</span>
                                        </button>
                                        <a href="{{route('system_admin.dashboard')}}" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                            <i class="flaticon-cancel"></i>
                                            <span>الغاء</span>
                                        </a>
                                    </div>
                                </div>

                            </div>





                            <div class="clearfix"></div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <div id="add_bank" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة بنك جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form action="{{route('system.banks.do.create')}}" id="form" method="post">
                    <div class="modal-body">
                        <?=csrf_field()?>
                        <input type="hidden" name="process" value="add">
                        <div class="form-group m-form__group @has_error('name')">
                            <label for="name">الاسم </label>
                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                <input type="text" class="form-control m-input m-input--pill m-input--air"
                                       placeholder="الاسم"
                                       required name="name" value="@old('name')" id="name">
                                <span class="m-input-icon__icon m-input-icon__icon--left"><span><i
                                            class="fa fa-money-bill-wave"></i></span></span>
                            </div>
                            @show_error('name')

                        </div>
                        <div class="form-group m-form__group @has_error('iban')">
                            <label for="iban">رقم الآيبان</label>
                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                <input type="text" class="form-control m-input m-input--pill m-input--air"
                                       placeholder="رقم الآيبان"
                                       required name="iban" value="@old('iban')" id="iban">
                                <span class="m-input-icon__icon m-input-icon__icon--left"><span><i
                                            class="fa fa-money-bill-wave"></i></span></span>
                            </div>
                            @show_error('iban')

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom"
                                data-dismiss="modal">اغلاق
                        </button>
                        <button type="submit"
                                class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">اضافة
                        </button>
                    </div>
                </form>
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
                messages: {
                    address: {
                        pattern: "{{trans('fe_messages.enter_numbers_letters_message')}}"
                    }
                }
            }).init();
        })
    </script>
    @if($errors->has('name')||$errors->has('iban'))
        <script>
            $(document).ready(function () {
                $('#add_bank').modal('show');
            });
        </script>
    @endif
@endsection
