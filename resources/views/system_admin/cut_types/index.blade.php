@extends('layouts.admin')
@php
    $Disname='أنواع التقطيع';
    $icon='fas fa-clipboard-check';
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
                        <a href="{{route('system_admin.generalProperties')}}" class="m-nav__link">
                            <span class="m-nav__link-text">الخصائص العامة</span>
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
                                @cando('add','cut_types')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.cut_types.create')}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة</span>
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

                                                        @cando('activate','cut_types')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.cut_types.activate')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-lock-open"></i>
                                                                <span class="m-nav__link-text">تفعيل</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.cut_types.deactivate')}}"
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
                                <form class="form-inline search_form">
                                    <div class="form-group m-form__group">

                                        <div class="input-group" >
                                            <input type="text" name="name_ar" class="form-control m-input m-input--pill filter-input" placeholder="الاسم باللغة العربية" value="{{ request('name_ar') }}" pattern="^[\u0621-\u064A0-9 -]+$">
                                            <div class="input-group-append">
                                                <button class=" btn m-btn--pill btn-outline-info m-btn filter-btn" type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>


                        </div>
                        @if(isset($out) && count($out) > 0)
                            <div >
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
                                        <th class="text-center">صورة التقطيع</th>
                                        <th class="text-center">الاسم</th>
                                        <th class="text-center">الحالة</th>
                                        <th class="text-center">الاعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{($out ->currentpage()-1) * $out ->perpage() + $loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table" style="display: {{$o->id != 14?'block':'none'}};">
                                                    <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                            <img style="background-color: #ccc;" src="{{ $o->image_thumbnail }}" class="img_table" alt="">
                                            </td>
                                            <td class="text-center">
                                                <p>{{ $o->name_ar }}</p>
{{--                                                <p>{{ $o->name_en }}</p>--}}
                                            </td>
                                            <td class="text-center">
                                                @if($o->status == 1)
                                                    <span class="m--font-success"> مفعل </span>
                                                @else
                                                    <span class="m--font-danger"> معطل </span>
                                                @endif
                                            </td>
                                            <td class="text-center">

                                                <ul class="list-inline">

                                                    @cando('edit','cut_types')
                                                    <li>
                                                        <a href="{{route('system.cut_types.update',$o->id)}}"
                                                           class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                                                           data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="تعديل"
                                                        >
                                                            <i class="fa fa-edit"></i> تعديل </a>
                                                    </li>
                                                    @endcando
                                                    @cando('delete','cut_types')
                                                    <li >
                                                        <?php if ($o->can_del && $o->id != 14) { ?>
                                                        <button class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del"
                                                                data-id="<?= $o->id ?>"
                                                                data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                                data-url="{{route('system.cut_types.delete')}}"
                                                                data-token="{{csrf_token()}}"
                                                                title="حذف"><i class="fa fa-trash"> </i>حذف
                                                        </button>
                                                        <?php }else{ ?>
                                                        <div style="display: inline-block;" data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                             title="لا يمكن الحذف لوجود طلبات تابعة له">
                                                            <a class=" btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom"
                                                               style="pointer-events: none;cursor: default;opacity: 0.7;color: #f4516c;"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                               title="لا يمكن الحذف لوجود طلبات تابعة له">
                                                                <i class="fa fa-trash"></i>حذف
                                                            </a>
                                                        </div>

                                                        <?php } ?>


                                                    </li>
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
                                <h4 class="block">لا يوجد بيانات مضافة</h4>
                            </div>
                        @endif

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
