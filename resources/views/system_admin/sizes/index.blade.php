@extends('layouts.admin')
@php
    $Disname='أحجام الحاشي';
    $icon='fa fa-shapes';
@endphp
@section('title', $Disname)
@section('head')
    <style>
        .img_table{
        width: 135px !important;
        height: 50px !important;
        border-radius: 5% !important;
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
                    <div class="m-portlet__head" style="/* height: 40px;  border-bottom: none; margin-bottom: 15px;*/">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                             <span class="m-portlet__head-icon">
                                                <i class="{{$icon}}" style=" color: #d53878;"></i>
                                            </span>
                                <h3 class="m-portlet__head-text" style=" color: #d53878;">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>
                        <form class="form-inline" style="/*float: left*/">
                            <div class="form-group ">
                                @component('components.serach.inputwithsearch',['inputs'=>['name'=>'الاسم']])@endcomponent
                            </div>
                        </form>
                    </div>
                    <div class="m-portlet__head" style="height:100px;background-color: #f7e8ee;">
                        <form class="form-inline">
                            <input type="hidden" id="instrumentId">
                            <div class="form-group" style="margin-left: 30px">
                                <label for="name_ar" class="" style="display: block">
                                    <div style="" class="">الاسم بالعربية</div>
                                    <div>

                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                            <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="الاسم" required="" name="name_ar" value="" id="name_ar">
                                            <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-shapes" style="color: #d53878;"></i></span></span>
                                        </div>
                                    </div>
                                    <div id="name_ar_error" style="display:none;padding: 5px;color: red;font-weight: bold;font-size: 11px;">
                                        هناك خطأ ما
                                    </div>
                                </label>
                            </div>
                            <div class="form-group" style="">
                                <label for="name_en" class="" style="display: block">
                                    <div style="" class="">الاسم بالانجليزية</div>
                                   <div>

                                       <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                           <input type="text" class="form-control m-input m-input--pill m-input--air" placeholder="Name" required="" name="name_en" value="" id="name_en">
                                           <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-shapes" style="color: #d53878;"></i></span></span>
                                       </div>
                                   </div>
                                    <div id="name_en_error" style="display:none;padding: 5px;color: red;font-weight: bold;font-size: 11px;">
                                        هناك خطأ ما
                                    </div>
                                </label>
                            </div>

                            @cando('add','sizes')
                            <button id="addSubCat" type="button" style="margin: 0 15px;margin-top: 18px;" class="btn m-btn--pill m-btn--air btn-success m-btn m-btn--custom">
                                <i class="fa fa-plus"></i>
                                <span>إضافة</span>
                            </button>
                            <button id="addcancel" type="button" style="display:none;margin: 0 15px;margin-top: 18px;" class="btn m-btn--pill m-btn--air btn-danger m-btn m-btn--custom">
                                <i class="fa fa-stop"></i>
                                <span>الغاء</span>
                            </button>
                            @endcando
                            @cando('edit','sizes')

                            <button id="editSubCat" type="button" style="display:none;margin: 0 15px;margin-top: 18px;" class="btn m-btn--pill m-btn--air btn-info m-btn m-btn--custom">
                                <i class="fa fa-edit"></i>
                                <span>تعديل</span>
                            </button>
                            <button id="cancel" type="button" style="display:none;margin: 0 15px;margin-top: 18px;" class="btn m-btn--pill m-btn--air btn-danger m-btn m-btn--custom">
                                <i class="fa fa-stop"></i>
                                <span>الغاء</span>
                            </button>
                            @endcando

                        </form>
                        <div class="m-portlet__head-tools">

                            <ul class="m-portlet__nav">

                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle btn m-btn--pill m-btn--air btn-primary m-btn m-btn--custom">
                                        <i class="fa fa-cog"></i>
                                        <span>العمليات</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        @cando('delete','sizes')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.sizes.delete')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon fa fa-trash "></i>
                                                                <span class="m-nav__link-text">حذف</span>
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
                    <div class="m-portlet__body" style=" margin-top: 0; padding-top: 15px;">
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
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{ ($out->currentpage()-1) * $out ->perpage() + $loop->index + 1 }}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                    <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                    <span></span>
                                                </label>
                                            </td>

                                            <td class="text-right">
                                                {{$o->name}}
                                            </td>
                                            <td class="text-center">

                                                <ul class="list-inline">

                                                    @cando('edit','sizes')
                                                    <li>
                                                        <button  id="{{$o->id}}" class="editCat btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom"  data-skin="dark" data-tooltip="m-tooltip"  data-placement="top" title="تعديل البيانات">
                                                            <i class="fa fa-edit"></i>
                                                        </button>
                                                    </li>

                                                    @endcando
                                                    @cando('delete','sizes')
                                                    @if($o->can_del)
                                                        <li>
                                                            <button type="button"
                                                                    data-id="<?= $o->id ?>"
                                                                    data-url="{{route('system.sizes.delete')}}"
                                                                    data-token="{{csrf_token()}}"
                                                                    data-skin="dark" data-tooltip="m-tooltip"
                                                                    data-placement="top" title="حذف"
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                                <i class="fa fa-trash "></i>
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
                            <div class="table-responsive" style="display: none">
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
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="note note-info" id="no_data">
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

    <style>


        .gold{
            color: #c9ab04;
        }
        .grey{
            color: grey;
        }

        .green{
            color: green;
        }
        .red{
            color: red;
        }
    </style>

    <script>
        $(function () {

            $("body").on('click','#addSubCat',
                function (e) {
                e.preventDefault();
                var name_ar=$('#name_ar').val();
                var name_en=$('#name_en').val();

                if(name_ar == ''){
                    $('#name_ar_error').empty().html('يجب تعبئة حقل الاسم بالعربية');
                    $('#name_ar_error').css('display','block');
                    $('#addcancel').css('display','block');
                    // swal({
                    //     title: 'خطأ إدخال',
                    //     text: 'يجب تعبئة حقل الاسم بالعربية ',
                    //     type: 'error',
                    //     timer: 4000,
                    //     showConfirmButton: false
                    // })
                }
                if(name_en == ''){
                    $('#name_en_error').empty().html('يجب تعبئة حقل الاسم بالانجليزية');
                    $('#name_en_error').css('display','block');
                    $('#addcancel').css('display','block');
                    // swal({
                    //     title: 'خطأ إدخال',
                    //     text: 'يجب تعبئة حقل الاسم بالانجليزية ',
                    //     type: 'error',
                    //     timer: 4000,
                    //     showConfirmButton: false
                    // })
                }

                var url='{{route("system.sizes.do.createj")}}';
                var token ='{{ csrf_token() }}';
                $.post(
                    url,
                    {
                        _token: token,
                        name_ar:name_ar,
                        name_en:name_en,
                    },
                function (data, status)
                {
                    if (data.done == 1) {
                        $('.note .note-info').remove();
                        swal({
                            title: 'تمت العملية بنجاح!',
                            text: 'تمت العملية بنجاح',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(
                            function () {
                                $('#name_ar').val('');
                                $('#name_en').val('');
                                $('#addcancel').css('display','none');
                                $('#name_en_error').css('display','none');
                                $('#name_en_error').empty();
                                $('#name_ar_error').css('display','none');
                                $('#name_ar_error').empty();
                                var table=$('.table');
                                console.log(data.html);
                                var rows = $('.table tbody tr').length;
if(rows == 0){
    $('.table tbody').append(data.html).fadeIn(600,function () {



        var num=1;
        table.find('.LOOPIDS').each(function(){
            $(this).text(num);
            num=num+1;
        });
    });

}else{
    $('.table tbody  tr:first').before(data.html).fadeIn(600,function () {



        var num=1;
        table.find('.LOOPIDS').each(function(){
            $(this).text(num);
            num=num+1;
        });
    });

}
                                $('.table-responsive').show();
                                $('#no_data').hide();

                                setTimeout(function(){
                                    $('.table tbody  tr:first').css('background','#dbf5f0');
                                }, 500);

                                setTimeout(function(){
                                    $('.table tbody  tr:first').css('background','#ffffff');
                                }, 5000);



                            }
                        )
                    } else {
                        if(data.errors.name_ar[0]){
                            $('#name_ar_error').empty().html(data.errors.name_ar[0]);
                            $('#name_ar_error').css('display','block');
                            $('#addcancel').css('display','block');
                        }
                        if(data.errors.name_en[0]){
                            $('#name_en_error').empty().html(data.errors.name_en[0]);
                            $('#name_en_error').css('display','block');
                            $('#addcancel').css('display','block');
                        }
                        // swal({
                        //     title: 'خطأ!تأكد من المدخلات',
                        //     text: data.errors.name[0],
                        //     type: 'error',
                        //     timer: 4000,
                        //     showConfirmButton: false
                        // })

                    }
                }
                )
            });
            $("body").on('click','#editSubCat',
                function (e) {
                e.preventDefault();
                var name_ar=$('#name_ar').val();
                var name_en=$('#name_en').val();
                var id=$('#instrumentId').val();

                    if(name_ar == ''){
                        $('#name_ar_error').empty().html('يجب تعبئة حقل الاسم بالعربية');
                        $('#name_ar_error').css('display','block');
                        $('#addcancel').css('display','block');
                        // swal({
                        //     title: 'خطأ إدخال',
                        //     text: 'يجب تعبئة حقل الاسم بالعربية ',
                        //     type: 'error',
                        //     timer: 4000,
                        //     showConfirmButton: false
                        // })
                    }
                    if(name_en == ''){
                        $('#name_en_error').empty().html('يجب تعبئة حقل الاسم بالانجليزية');
                        $('#name_en_error').css('display','block');
                        $('#addcancel').css('display','block');
                        // swal({
                        //     title: 'خطأ إدخال',
                        //     text: 'يجب تعبئة حقل الاسم بالانجليزية ',
                        //     type: 'error',
                        //     timer: 4000,
                        //     showConfirmButton: false
                        // })
                    }

                var url='{{route("system.sizes.do.updatej")}}';
                var token ='{{ csrf_token() }}';
                $.post(
                    url,
                    {
                        _token: token,
                        name_ar:name_ar,
                        name_en:name_en,
                        id:id
                    },
                function (data, status)
                {
                    if (data.done == 1) {
                        swal({
                            title: 'تمت العملية بنجاح!',
                            text: 'تمت عملية التعديل بنجاح',
                            type: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(
                            function () {
                                var table=$('.table');
                               $('#TR_'+id).find('td:eq(2)').empty().append(name_ar);

                                $('#editSubCat').hide();
                                $('#cancel').hide();
                                $('#addSubCat').show();
                                $('#name_ar').val('');
                                $('#name_en').val('');
                                $('#addcancel').css('display','none');
                                $('#name_en_error').css('display','none');
                                $('#name_en_error').empty();
                                $('#name_ar_error').css('display','none');
                                $('#name_ar_error').empty();
                                $('#instrumentId').val('');
                            }
                        )
                    } else {

                        if(data.errors.name_ar[0]){
                            $('#name_ar_error').empty().html(data.errors.name_ar[0]);
                            $('#name_ar_error').css('display','block');
                            $('#addcancel').css('display','block');
                        }
                        if(data.errors.name_en[0]){
                            $('#name_en_error').empty().html(data.errors.name_en[0]);
                            $('#name_en_error').css('display','block');
                            $('#addcancel').css('display','block');
                        }
                        // swal({
                        //     title: 'خطأ!تأكد من المدخلات',
                        //     text: data.errors.name[0],
                        //     type: 'error',
                        //     timer: 4000,
                        //     showConfirmButton: false
                        // })

                    }
                }
                )
            });
            $("body").on('click','.editCat',
                function () {
                var id=$(this).attr('id');
                var url='{{route('system.sizes.getInfo')}}';
                $.get(
                    url ,
                    {
                        id : id,
                    },
                    function (data,status) {
                        if(data.done == 1){
                        $('#name_ar').val(data.name_ar);
                        $('#name_en').val(data.name_en);
                            $('#addcancel').css('display','none');
                            $('#name_en_error').css('display','none');
                            $('#name_en_error').empty();
                            $('#name_ar_error').css('display','none');
                            $('#name_ar_error').empty();
                        $('#instrumentId').val(data.id);
                        $('#editSubCat').show();
                        $('#cancel').show();
                        $('#addSubCat').hide();
                        }
                    }

                );
            });
            $("body").on('click','#cancel',
                function () {

                    $('#editSubCat').hide();
                    $('#cancel').hide();
                    $('#addSubCat').show();
                    $('#name_ar').val('');
                    $('#name_en').val('');
                    $('#name_en_error').css('display','none');
                    $('#name_en_error').empty();
                    $('#name_ar_error').css('display','none');
                    $('#name_ar_error').empty();
                    $('#instrumentId').val('');
            });
            $("body").on('click','#addcancel',
                function () {
                    $('#addcancel').hide();
                    $('#name_ar').val('');
                    $('#name_en').val('');
                    $('#name_en_error').css('display','none');
                    $('#name_en_error').empty();
                    $('#name_ar_error').css('display','none');
                    $('#name_ar_error').empty();

            });
        })
    </script>
@endsection
