@extends('layouts.admin')
@php
    $Disname='المقاسات';
    $icon=' fas fa-clipboard-check';

@endphp
@section('title', $Disname)

@section('head')
    <link href="{{asset('admin/jquery.minicolors.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .imageAndSizeOb {
            border: 2px solid #ddd;
            border-radius: 20px;
            margin: 15px;
        }

        .imageAndSizeOb img {
            width: 100px;
            float: right;
            height: 100px;
            border-radius: 20px;
        }

        .imageAndSizeOb .colorbox {
            float: right;
            width: 70px;
            height: 70px;
            line-height: 70px;
            margin: 15px 20px;
            border: 1px solid #ddd;
            border-radius: 20px;
            text-align: center;
            cursor: pointer;
            overflow: hidden;
        }

        .imageAndSizeOb .sizebox {
            float: right;
            width: 70px;
            height: 70px;
            line-height: 70px;
            margin: 15px 10px;
            border: 1px solid #ddd;
            border-radius: 20px;
            text-align: center;
            cursor: pointer;
            overflow: hidden;
        }

        .colorItem {
            width: 50px;
            height: 50px;
            border-radius: 22px;
            margin: 10px;
            cursor: pointer;
            overflow: hidden;
            text-align: center;
            line-height: 50px;
        }

        .colorAdd {
            width: 50px;
            height: 50px;
            border-radius: 22px;
            margin: 10px;
            cursor: pointer;
            border: 2px solid #ddd;
            line-height: 50px;
            text-align: center;
            padding: 0;
            color: #878787;
        }

        .sizeItem {
            min-width: 50px;
            height: 50px;
            border-radius: 22px;
            margin: 10px;
            cursor: pointer;
            border: 2px solid #ddd;
            line-height: 42px;
            text-align: center;
            padding: 0;
            color: #878787;
            font-size: 18px;
            font-weight: 600;
            overflow: hidden;
        }

        .used{
            border: 2px solid #5daf24 !important;
            background: #f8f8f8;
        }
        .sizeAdd {
            width: 50px;
            height: 50px;
            border-radius: 22px;
            margin: 10px;
            cursor: pointer;
            border: 2px solid #ddd;
            line-height: 50px;
            text-align: center;
            padding: 0;
            color: #878787;
        }


    </style>
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
                                <li class="m-portlet__nav-item">

                                    <button  data-toggle="modal" data-target="#ColorsModal" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة</span>
                                    </button>
                                </li>

                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">

            @if(isset($out) && count($out) > 0)
                            <div class="sizeSelectArea row justify-content-center">

                                @foreach($out as $c)
                                    <div class="sizeItem" data-skin="dark" data-tooltip="m-tooltip"
                                         data-placement="bottom" title="حذف" data-name="{{$c->name}}" data-id="{{$c->id}}">{{$c->name}}</div>
                                @endforeach

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
    <div class="modal" id="ColorsModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal body -->
                <div class="modal-body">


                    <div class="colorAddArea" style="margin-top: 10px;">
                        <h3 style="text-align: center"> اضافة مقاس جديد</h3>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                @component('components.input',['name'=>'Size_name_ar','text'=>'الاسم','placeholder'=>'ادخل الاسم'])
                                @endcomponent
                            </div>

                            <div class="col-md-8">
                                @component('components.input',['name'=>'Size_name_en','text'=>'name','placeholder'=>'name in english'])
                                @endcomponent
                            </div>
                            <div class="w-100"></div>


                            <button type="button"
                                    class="btn m-btn--pill m-btn--air btn-outline-info m-btn m-btn--custom btn_addSize">
                                <i class="fa fa-plus"></i>
                                <span>اضافة</span>
                            </button>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script>
        $(function () {

            $("body").on('click', '.btn_addSize',
                function () {
                    var token = '{{csrf_token()}}';


                    var usedItems=[];
                    $('.used').each(function () {
                        var id=$(this).data('id');
                        usedItems.push(id);
                    });

                    var name_ar = $('#Size_name_ar').val();
                    var name_en = $('#Size_name_en').val();
                    if (name_ar == '') {
                        alert('الرجاء ادخال الاسم');
                        return;
                    }
                    if (name_en == '') {
                        name_en = name_ar;
                    }

                    $.post('{{route('system.sizes.createJson')}}',
                        {
                            _token: token,
                            name_ar: name_ar,
                            name_en: name_en,
                        },
                        function (data, status) {
                            if (data.done == 1) {

                                $('#Size_name_ar').val('');
                                $('#Size_name_en').val('');
                                $('.sizeSelectArea').html(data.out);

                                $('.sizeItem').each(function () {
                                    var id=$(this).data('id');
                                    if(usedItems.indexOf(id) != -1){
                                        $(this).addClass('used');
                                    }

                                });

                            }
                        })

                });
            $('body').on('click', '.sizeItem', function () {

                var id = $(this).data('id');
                swal(
                    {
                        title:"هل انت متأكد ؟",
                        text:"هل تريد بالتأكيد حذف المقاس",
                        type:"warning",
                        showCancelButton:1,
                        confirmButtonText:"نعم , قم بالحذف !",
                        cancelButtonText:"لا, الغي العملية !",
                        reverseButtons:1
                    }).then(function(e){

                    if(e.value){

                        $.post('{{route('system.sizes.delete')}}',
                            {
                                _token: '{{csrf_token()}}',
                                id: id,
                            },
                            function (data, status) {
                                if (data.done == 1) {
                                    $('.sizeSelectArea').html(data.out);
                                    swal({
                                        title: 'تم الحذف بنجاح',
                                        text: 'تم الحذف بنجاح',
                                        type: 'success',
                                        timer: 2000,
                                        showConfirmButton: false
                                    })
                                } else {

                                    swal({
                                        title: data.res_text,
                                        text: 'خطأ',
                                        type: 'error',
                                        timer: 4000,
                                        showConfirmButton: false
                                    })

                                }
                            }).fail(function(data2,status) {
                            var data2=data2.responseJSON;
                            swal({
                                title: 'خطأ',
                                text: data2.response_message,
                                type: 'error',
                                timer: 4000,
                                showConfirmButton: false
                            })
                        });

                    }else{
                        e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                    }
                });

            });
        })
    </script>
@endsection
