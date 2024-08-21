@extends('layouts.admin')
@php
    $Disname='المنتجات';
    $icon='fa fa-products';
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
                        <a href="{{route('system.products.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">{{$product->name}}</span>
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
                                @cando('add','product_variants')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.product_variants.create',['id'=>$product->id])}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة</span>
                                    </a>
                                </li>
                                @endcando
                                @cando('edit','product_variants')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.product_variants.update',['id'=>$product->id])}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-edit"></i>
                                        <span>تعديل</span>
                                    </a>
                                </li>
                                @endcando
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
                                                        @cando('delete','product_variants')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.product_variants.delete')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon flaticon-delete "></i>
                                                                <span class="m-nav__link-text">حذف</span>
                                                            </a>
                                                        </li>
                                                        @endcando

                                                        @cando('activate','product_variants')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.product_variants.activate')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-lock-open"></i>
                                                                <span class="m-nav__link-text">تفعيل</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.product_variants.deactivate')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-lock "></i>
                                                                <span class="m-nav__link-text">تعطيل</span>
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

                                        @component('components.serach.selectArr',['key'=>'status',
                                 'text'=>'اختر الحالة',
                                 'select'=>[1=>'مفعل',2=>'معطل']])
                                        @endcomponent
                                        @if(count($has_colors))
                                        <div class="input-group">
                                            <select name="color_id" class="autoSubmit" search="true" id="color_id" >
                                                <option value="-1" {{HELPER::set_if($_GET['color_id'],-1) == -1?'selected':''}}>بحث حسب اللون </option>
                                                @foreach($colors as $r)
                                                    <option value="{{$r->id}}" {{HELPER::set_if($_GET['color_id']) == $r->id?'selected':''}}>{{$r->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @endif
                                            @if(count($has_sizes))
                                        <div class="input-group">
                                            <select name="size_id" class="autoSubmit" search="true" id="size_id" >
                                                <option value="-1" {{HELPER::set_if($_GET['size_id'],-1) == -1?'selected':''}}>بحث حسب الحجم </option>
                                                @foreach($sizes as $r)
                                                    <option value="{{$r->id}}" {{HELPER::set_if($_GET['size_id']) == $r->id?'selected':''}}>{{$r->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                            @endif
                                            @if(count($has_metrics))
                                            <div class="input-group">
                                            <select name="metric_id" class="autoSubmit" search="true" id="metric_id" >
                                                <option value="-1" {{HELPER::set_if($_GET['metric_id'],-1) == -1?'selected':''}}>بحث حسب المقاس </option>
                                                @foreach($metrics as $r)
                                                    <option value="{{$r->id}}" {{HELPER::set_if($_GET['metric_id']) == $r->id?'selected':''}}>{{$r->name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                            @endif
                                            @component('components.serach.input',['inputs'=>['price_from'=>'السعر من','price_to'=>'السعر الى']])
                                            @endcomponent
                                        @component('components.serach.inputwithsearch',['inputs'=>['name'=>'الاسم']])
                                        @endcomponent

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
                                        <th class="text-right">الإسم</th>
                                        @if(count($has_sizes))
                                        <th class="text-center">الحجم</th>
                                        @endif
                                        @if(count($has_metrics))
                                        <th class="text-center">المقاس</th>
                                        @endif
                                        @if(count($has_colors))
                                        <th class="text-center">اللون</th>
                                        @endif
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                    <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td class="text-right">
                                                <img src="{{$o->image->image_url}}" class="img_table" alt="">
                                                {{$o->name}}
                                            </td>
                                            @if(count($has_sizes))
                                            <td class="text-center"> {{@$o->size?$o->size->name:'-'}}</td>
                                            @endif
                                            @if(count($has_metrics))
                                            <td class="text-center"> {{$o->metric?$o->metric->name:'-'}}</td>
                                            @endif
                                            @if(count($has_colors))
                                            <td class="text-center"> {{$o->color?$o->color->name:'-'}}</td>
                                            @endif
                                            <td class="text-center"> @if($o->has_discount) <span class="old_price">{{$o->real_price}}</span>  <span class="new_price">{{$o->end_price}} {{HELPER::set_if($config['currency_ar'])}}</span>@else {{$o->end_price}}  {{HELPER::set_if($config['currency_ar'])}}@endif</td>

                                            <td class="text-center">
                                                @if($o->status == 1)
                                                    <span class="m--font-success"> مفعل </span>
                                                @elseif($o->status == 2)
                                                    <span class="m--font-danger"> معطل </span>
                                                @elseif($o->status == 0)
                                                    <span class="m--font-warning"> غير مؤكد </span>

                                                @else
                                                    <span class="m--font-warning"> مجهول </span>
                                                @endif
                                            </td>
                                            <td class="text-center">

                                                <ul class="list-inline">
                                                    @cando('delete','product_variants')
                                                    @if($o->can_del)
                                                        <li>
                                                            <button type="button"
                                                                    data-id="<?= $o->id ?>"
                                                                    data-url="{{route('system.product_variants.delete')}}"
                                                                    data-token="{{csrf_token()}}"
                                                                    data-skin="dark" data-tooltip="m-tooltip"
                                                                    data-placement="top" title="حذف"
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>


                                                        </li>
                                                    @else
                                                        <li>
                                                            <button type="button"
                                                                    data-skin="dark" data-tooltip="m-tooltip"
                                                                    data-placement="top" title="لا يمكن الحذف"
                                                                    disabled
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom disabled">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>


                                                        </li>

                                                    @endif
                                                    @endcando
                                                </ul>

                                            </td>
                                        </tr>
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

@endsection
