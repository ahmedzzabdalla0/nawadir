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
                    </div>
                    <div class="m-portlet__body">
                        <form id="form"  method="post" action="{{ route('system.product_variants.do.update') }}">
                            @csrf
                            <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                        @if(isset($out) && count($out) > 0)

                            <div>
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr >


                                        <th>#</th>
                                        <th class="text-center">الإسم</th>
                                        <th class="text-center">السعر</th>
                                        <th class="text-center">الصورة</th>
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td class="text-right">
                                                <input type="hidden" name="ids[]" value="{{$o->id}}">
                                                {{$o->name}}
                                            </td>
                                            <td class="text-center">
                                                <input type="number" class="form-control m-input m-input--pill" placeholder="السعر"
                                                       name="prices[]" min="0.1" value="{{$o->price}}">
                                            </td>
                                            <td class="text-center">
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <div class="input-group">
                                                        <div class="m-card-profile__pic">
                                                            <div class="m-card-profile__pic-wrapper">
                                                                <div class="image-container" style="margin: 10px;">
                                                                    <img class="image-preview" id="image_preview_{{$o->id}}" src="{{$o->image?$o->image->image_url:url('avatar.png')}}" style="height: 50px;width: 50px;" alt="" />
                                                                    <div class="middle">
                                                                        <a style="color:#777;height: 50px;width: 50px;" class="show_choose_images" data-id="{{$o->id}}" data-name="{{$o->name}}"  href="javascript:;">
                                                                            <i class="fa fa-3x fa-plus-circle"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="images[]" id="image_{{$o->id}}" value="{{$o->image->id}}">
                                                </div>
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
                        @else
                            <div class="note note-info">
                                <h4 class="block">لا يوجد بيانات للعرض</h4>
                            </div>
                        @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" id="confirm"
                                            class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-check"></i>
                                        <span>تعديل</span>
                                    </button>
                                    <a href="{{route('system.product_variants.index',['id',$product->id])}}" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                        <i class="flaticon-cancel"></i>
                                        <span>الغاء</span>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" id="submit" style="display: none;"
                                            class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-check"></i>
                                        <span>تعديل</span>
                                    </button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div id="choose_images" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" >

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اختر صورة المنتج(<span id="product_name_choose"></span>)</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="product_id_choose" type="hidden">
                    <div class="row" id="preview_images_cont">

                    </div>
                    <br>
                    <div><a href="javascript:;" id="add_image" class="btn btn-xs btn-primary" >اضافة صورة جديدة</a></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cancel_image_addition" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom" data-dismiss="modal">اغلاق</button>
                    <button type="button" id="confirm_image_addition" class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom" data-dismiss="modal">تأكيد</button>
                </div>
            </div>

        </div>
    </div>
    <div id="upload_new_images" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" >

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اضافة صورة جديدة(<span id="product_name_upload"></span>) </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form  id="images_form" >
                    <div class="modal-body">
                        <input name="product_id_upload" id="product_id_upload" type="hidden">
                        @csrf
                        <div>
                            @component('components.upload_image_create',['name'=>'multi_images','name1'=>'def_image','text'=>'none'])
                            @endcomponent
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom" data-dismiss="modal">اغلاق</button>
                        <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">اضافة</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
@section('custom_scripts')


    <script>
        $(function () {
            var form = $('#form');
            var baseurl = '{{url('uploads')}}';
            form.validate({
                errorElement: 'div', //default input error message container
                errorClass: 'abs_error help-block has-error',
                rules: {
                    price: {
                        required: true,
                        number: true
                    }
                }

            }).init();


            $('#confirm').on('click', function () {
                    if (form.valid()) {
                        $('#submit').click();
                    }
            });


        });

        $(document).ready(function () {
var image_url = '';
var image_id = 0;
            $(document).on('click','.show_choose_images',function(e){
                e.preventDefault();
                var id = $(this).attr('data-id');
                var name = $(this).attr('data-name');
                $('#product_name_choose').empty().html(name);
                $('#product_name_upload').empty().html(name);
                $('#product_id_choose').val(id);
                $('#product_id_upload').val(id);
                loadImages({{$product->id}});
                 $('#choose_images').modal({
                        // backdrop:'static',
                        keyboard:false
                    });
            });

            $('#confirm_image_addition').click(function(e){
                e.preventDefault();
              var id = $('#product_id_choose').val();
              $('#image_'+id).val(image_id);
              $('#image_preview_'+id).attr('src',image_url);


                $('div.added-on-image').map(function() {
                    if($(this).hasClass('deleted')) {
                        $(this).remove();
                    }
                });
            });
            $('#cancel_image_addition').click(function(e){
                e.preventDefault();
                $('a.choose_image').map(function() {
                        $(this).parent('div.middle').siblings('img.image-preview').css('border', 'none');
                });


            });
            $(document).on('click','.choose_image', function(e) {
                var id = $(this).data('id');
                var src = $(this).data('url');
                image_id=id;
                image_url=src;
                $(this).parent('div.middle').siblings('img.image-preview').css('border','#19708a solid 3px');
                $('a.choose_image').map(function() {
                    if($(this).attr('data-id') != id) {
                        $('#image_'+$(this).attr('data-id')).val();
                        $(this).parent('div.middle').siblings('img.image-preview').css('border', 'none');

                    }
                });
            });
            $( "#images_form" ).submit(function( event ) {

                event.preventDefault();

                $.ajax({
                    type: "post",
                    url: "{{route('system.product_variants.uploadImageAjax')}}",
                    data: $(this).serialize(),
                    cache: false,
                    success: function(data, textStatus, xhr){

                        if(xhr.status == 200){
                            //loadImages(data.success)
                            //$('#choose_images').modal('show');
                            // $('#upload_new_images').modal('hide');
                            var id = data.file.id;
                            var src =  data.file.image_url;
                            var product_id = $('#product_id_choose').val();
                            $('#image_'+product_id).val(id);
                            $('#image_preview_'+product_id).attr('src',src);
                            $('#upload_new_images').modal('hide');
                        }
                    },

                });


            });

            $(document).on('click','#add_image',function(e){
                e.preventDefault();
                $('#choose_images').modal('hide');
                $('#upload_new_images').modal('show');
            });

            function loadImages(id){
                if(id != 0){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "get",
                        url: '{{ route('admin.getProductImages') }}',
                        data: {id:id},
                        cache: false,
                        success: function(data, textStatus, xhr){
                            if(data.error){
                                swal({
                                    title: 'حدث خطأ ما',
                                    text: 'حدث خطأ ما',
                                    type: 'error',
                                    timer: 4000,
                                    showConfirmButton: false
                                })
                            }else{
                                if(xhr.status == 200){
                                    var images_api = data.images;
                                    var preview_images_cont = $('#preview_images_cont');
                                    preview_images_cont.empty();

                                    if(images_api.length>0){
                                        preview_images_cont.empty();
                                        for(var i = 0;i<images_api.length;i++){
                                            var div = '<div class="col-md-4" style="margin-bottom:10px;padding:5px;">\n' +
                                                '                                <div class="image-container" style="width:100%">\n' +
                                                '                                    <img class="image-preview" src="'+images_api[i].image_url+'" style="height: 150px;" alt="" />\n' +
                                                '                                    <div class="middle">\n' +
                                                '                                        <a style="color:#777;height: 150px;width: 150px;" class="choose_image"  href="javascript:;" data-id="'+images_api[i].id+'" data-url="'+images_api[i].image_url+'">\n' +
                                                '                                            <i class="fa fa-3x fa-plus-circle"></i>\n' +
                                                '                                        </a>\n' +
                                                '                                    </div>\n' +
                                                '                                </div>\n' +
                                                '                            </div>';
                                            preview_images_cont.append(div);
                                        }
                                       var old_image_id = $('#image_'+$('#product_id_choose').val()).val();
                                        if(old_image_id>0){
                                            $('a.choose_image').map(function() {
                                                if($(this).attr('data-id')===old_image_id){
                                                    $(this).parent('div.middle').siblings('img.image-preview').css('border','#19708a solid 3px');
                                                }
                                            });
                                        }
                                    }else{
                                        preview_images_cont.empty().html('<h5 style="width:100%;">لا يوجد صور مضافة للمنتج</h5>')
                                    }

                                }
                            }

                        },

                    });
                }
            }
        });
    </script>

@endsection
