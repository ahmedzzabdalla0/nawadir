@extends('layouts.admin')
@php
    $Disname='التصنيفات';
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
                                @cando('add','categories')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.categories.create')}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة</span>
                                    </a>
                                </li>
                                @endcando

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
                                            <input type="text" name="name_en" class="form-control m-input m-input--pill filter-input" placeholder="الاسم باللغة الانجليزية" value="{{ request('name_en') }}" pattern="^[a-zA-Z0-9 -]+$">
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
                                        <th class="text-center">صورة التصنيف</th>
                                        <th class="text-center">الاسم</th>
                                        <th class="text-center">عدد المنتجات</th>
                                        <th class="text-center" width="70px">الترتيب</th>
{{--                                        <th class="text-center">الحالة</th>--}}
                                        <th class="text-center">الاعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{($out ->currentpage()-1) * $out ->perpage() + $loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                    <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                    <span></span>
                                                </label>
                                            </td>
                                            <td>
                                            <img style="background-color: #ccc;" src="{{ $o->image_thumbnail }}" class="img_table" alt="">
                                            </td>
                                            <td class="text-center">
                                                <p>{{ $o->name_ar }}</p>
{{--                                                <p>{{$o->name_en}}</p>--}}
                                            </td>
                                            <td class="text-center">
                                                <p>{{ $o->products_count }}</p>
                                            </td>
                                            <td class="text-center">

                                                <select class="category_sort"  data-id="{{$o->id}}">
                                                    @for($sort = 0;$sort<count($count);$sort++)
                                                        <option value="{{ $count[$sort] }}" {{ $count[$sort] == $o->sorted ? 'selected':'' }}>{{ $count[$sort] }}</option>
                                                    @endfor
                                                </select>

                                            </td>
{{--                                            <td class="text-center">--}}
{{--                                                @if($o->status == 1)--}}
{{--                                                    <span class="m--font-success"> مفعل </span>--}}
{{--                                                @else--}}
{{--                                                    <span class="m--font-warning"> معطل </span>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
                                            <td class="text-center">

                                                <ul class="list-inline">

                                                    @cando('edit','categories')
                                                    <li>
                                                        <a href="{{route('system.categories.update',$o->id)}}"
                                                           class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"
                                                           data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="تعديل"
                                                        >
                                                            <i class="fa fa-edit"></i> تعديل </a>
                                                    </li>
                                                    @endcando
                                                    @cando('delete','categories')
                                                    <li style="display:{{in_array($o->id,[1])?'none':'block'}};">
                                                        <?php if ($o->can_del) { ?>
                                                        <button class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del"
                                                                data-id="<?= $o->id ?>"
                                                                data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                                data-url="{{route('system.categories.delete')}}"
                                                                data-token="{{csrf_token()}}"
                                                                title="حذف"><i class="fa fa-trash"> </i>حذف
                                                        </button>
                                                        <?php }else{ ?>
                                                        <div style="display: inline-block;" data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                             title="لا يمكن الحذف لوجود منتجات تابعة له">
                                                            <a class=" btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom"
                                                               style="pointer-events: none;cursor: default;opacity: 0.7;color: #f4516c;"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                               title="لا يمكن الحذف لوجود منتجات تابعة له">
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
@section('custom_scripts')
    <script>
        $(document).ready(function () {
            $('.nice-select').css('min-width', '70px');
            $('#category_sort').css('min-width', '70px');

            $("body").on('change','.category_sort',
                function () {
                    var Id = $(this).data('id');
                    var sort = $(this).val();
                    var url = "{{route('system.categories.sortCategory')}}";
                    var token = "{{csrf_token()}}";
                    $.post(url,
                        {
                            _token: token,
                            id: Id,
                            sort: sort,
                        },
                        function (data, status) {
                            if (data.done == 1) {
                                window.location.href = window.location.href;
                                // setTimeout(function(){
                                //     window.location.reload();
                                // });
                            } else {

                                var msg = 'حدث خطأ ما!';
                                if (data.message){
                                    msg = data.message;
                                }
                                swal({
                                    title: 'حدث خطأ ما!',
                                    text: msg,
                                    type: 'error',
                                    timer: 4000,
                                    showConfirmButton: false
                                })


                            }
                        })
                });
        });
    </script>
@endsection
