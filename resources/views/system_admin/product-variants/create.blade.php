@extends('layouts.admin')

@php
    $Disname='المنتجات';
@endphp
@section('title',  $Disname)
@section('head')
    <link rel="stylesheet" href="{{asset('admin/jquery.minicolors.css')}}">

@endsection
@section('page_content')

    <div class="m-content">
        <div class="row">

            <div class="col-lg-12">
                <div class="m-portlet">
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
                    </div>


                    <div class="m-portlet__body">

                        <!-- BEGIN FORM-->

                        <form action="{{route('system.product_variants.do.create')}}" id="form" method="post"

                              class="form-horizontal">

                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">
                            <div class="row justify-content-center">

                                <div class="col-md-3">
                                    <div class="form-group m-form__group @has_error('image')">
                                        <h4 style="text-align: center;">صورة المنتج </h4>
                                    <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                        <div class="input-group">
                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper">
                                                    <div class="image-container" style="width:100%">
                                                        <img class="image-preview" id="image_preview" src="{{old('image')?\App\Models\ProductImage::find(old('image'))->image_url:url('avatar.png')}}" style="height: auto;" alt="" />
                                                        <div class="middle">
                                                            <a style="color:#777;height: 150px;width: 150px;" class="show_choose_images"  href="javascript:;">
                                                                <i class="fa fa-3x fa-plus-circle"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="image" id="image" value="{{old('image')}}">
                                    </div>
                                        @show_error('image')
                                    </div>
                                </div>
                                @if(count($sizes))
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group @has_error('size_id')">
                                        <label for="size_id">الحجم</label>
                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                            <div class="input-group">
                                                <select search="true" class="m-input m-input--pill m-input--air" name="size_id" id="size_id" required>
                                                    @forelse($sizes as $parent)
                                                        <option value="{{ $parent->id }}"  {{ old('size_id')==$parent->id?'selected':'' }}>{{ $parent->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        @show_error('size_id')
                                    </div>
                                </div>
                                @endif
                                @if(count($metrics))
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group @has_error('metric_id')">
                                        <label for="metric_id">المقاس</label>
                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                            <div class="input-group">
                                                <select search="true" class="m-input m-input--pill m-input--air" name="metric_id" id="metric_id" required>
                                                    @forelse($metrics as $parent)
                                                        <option value="{{ $parent->id }}"  {{ old('size_id')==$parent->id?'selected':'' }}>{{ $parent->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        @show_error('metric_id')
                                    </div>
                                </div>
                                @endif
                                @if(count($colors))
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group @has_error('color_id')">
                                        <label for="color_id">اللون</label>
                                        <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                            <div class="input-group">
                                                <select search="true" class="m-input m-input--pill m-input--air" name="color_id" id="color_id" required>
                                                    @forelse($colors as $parent)
                                                        <option value="{{ $parent->id }}"  {{ old('color_id')==$parent->id?'selected':'' }}>{{ $parent->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        @show_error('color_id')
                                    </div>
                                </div>
                                @endif
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    @component('components.input',['type'=>'number','min'=>.1,'name'=>'price','text'=>'السعر','placeholder'=>'ادخل السعر','icon'=>'fa-dollar-sign'])
                                    @endcomponent
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    @component('components.input',['type'=>'number','min'=>1,'name'=>'qty','text'=>'الكمية المتوفرة','placeholder'=>'ادخل الكمية','icon'=>'fa-tags'])
                                    @endcomponent
                                </div>
                                <div class="w-100"></div>

                            </div>


                            <div class="row  justify-content-center">
                                <button type="submit" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>اضافة</span>
                                </button>
                                <a href="{{route('system.product_variants.index',['id',$product->id])}}" style="margin: 10px;" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                    <i class="flaticon-cancel"></i>
                                    <span>الغاء</span>
                                </a>
                            </div>

                        </form>

                        <!-- END FORM-->

                    </div> </div>
            </div>

        </div>

    </div>
    <div id="choose_images" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" >

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">اختر صورة المنتج</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <div class="modal-body">
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
                    <h4 class="modal-title">اضافة صورة جديدة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="fa fa-times"></i></span>
                    </button>
                </div>
                <form  id="images_form" >
                    <div class="modal-body">
                        <input name="product_id" id="product_id" value="{{$product->id}}" type="hidden">
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
                var qty = 0;
                var total_qty = parseInt($('#added_qty').val());
                $('.qty').each(function () {
                    qty += parseInt($(this).val());
                });
                console.log(qty);
                if(total_qty != qty){
                    swal('الرجاء توزيع الكمية المضافة على المنتجات');
                }else{
                    if (form.valid()) {
                        $('#submit').click();
                    }
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
                loadImages({{$product->id}});
                $('#choose_images').modal({
                    // backdrop:'static',
                    keyboard:false
                });
            });

            $('#confirm_image_addition').click(function(e){
                e.preventDefault();
                var id = $('#product_id_choose').val();
                $('#image').val(image_id);
                $('#image_preview').attr('src',image_url);


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
                        $('#image').val();
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
                            $('#image').val(id);
                            $('#image_preview').attr('src',src);
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
                                        var old_image_id = $('#image').val();
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


