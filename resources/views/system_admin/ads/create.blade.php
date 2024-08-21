@extends('layouts.admin')

@php
    $Disname='الأعلانات';
@endphp
@section('title',  $Disname)
@section('head')
    {{--<link rel="stylesheet" href="{{ url('admin/jquery-emoji-picker-master/css/jquery.emojipicker.css')}}">--}}
    <link rel="stylesheet" href="{{ url('admin/onesignal-emoji/css/emoji.css')}}">
    {{--<script src="//code.jquery.com/jquery.min.js"></script>--}}
    {{--<script src="{{ url('admin/jquery-emoji-picker-master/js/jquery.emojipicker.js')}}"></script>--}}
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
                        <a href="{{route('system.notifications.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">اضافة</span>
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
                                                <i class="fa fa-bell"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="m-portlet__body">
                        <form action="{{route('system.ads.do.create')}}" id="form" method="post" enctype="multipart/form-data">
                            @csrf 
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="row justify-content-center">
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('title')">
                                                <label for="title">العنوان</label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder="العنوان"
                                                           required name="title" value="@old('title')" id="title">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('title')

                                            </div>


                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col">
                                            <div class="form-group m-form__group @has_error('body')">
                                                <label for="body">نص الأعلان </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="text" class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder="نص الأعلان"
                                                           required name="body" value="@old('body')" id="body">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('body')

                                            </div>


                                        </div>
                                        <div class="w-100"></div>
                                        
                                        
                                                   <div class="col">
                                            <div class="form-group m-form__group @has_error('image')">
                                                <label for="image">صورة الأعلان </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="file" class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder="صورة الأعلان"
                                                           required name="image" value="@old('image')" id="image">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('image')

                                            </div>


                                        </div>
                                        <div class="w-100"></div>
                                             
                                                   <div class="col">
                                            <div class="form-group m-form__group @has_error('slider')">
                                                <label for="slider"> يظهر في نافذة منبثقة </label>
                                                <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                    <input type="checkbox" value="2" class="form-control m-input m-input--pill m-input--air" data-emojiable="true"  placeholder="يظهر في نافذة منبثقة"
                                                            name="slider" value="@old('slider')" id="slider">
                                                    {{--<span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fa fa-list-alt"></i></span></span>--}}
                                                </div>
                                                @show_error('slider')

                                            </div>


                                        </div>
                                        <div class="w-100"></div>
                                 
                                    </div>

                                </div>

                                <div class="clearfix"></div>
                            </div>
                            <div class="col row justify-content-center">
                                <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-success m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>اضافة</span>
                                </button>
                                <a href="{{route('system.ads.index')}}" class="btn m-btn--pill m-btn--air btn-outline-dark m-btn m-btn--custom">
                                    <i class="flaticon-cancel"></i>
                                    <span>الغاء</span>
                                </a>
                            </div>
                        </form>

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection





@section('custom_scripts')

    <script src="{{ url('admin/onesignal-emoji/js/config.js')}}"></script>
    <script src="{{ url('admin/onesignal-emoji/js/util.js')}}"></script>
    <script src="{{ url('admin/onesignal-emoji/js/jquery.emojiarea.js')}}"></script>
    <script src="{{ url('admin/onesignal-emoji/js/emoji-picker.js')}}"></script>
    <script>
        $(function () {

                $('#form').validate({
                errorElement: 'div', //default input error message container
                errorClass: 'abs_error help-block has-error',
                rules: {
                    price: {
                        required: true,
                        number: true
                    }
                }

            }).init();


        });
        $(function () {
            $(function() {
                // Initializes and creates emoji set from sprite sheet
                window.emojiPicker = new EmojiPicker({
                    emojiable_selector: '[data-emojiable=true]',
                    assetsPath: '{{ url('admin/onesignal-emoji/img')}}',
                    popupButtonClasses: 'fa fa-smile'
                });
                // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
                // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
                // It can be called as many times as necessary; previously converted input fields will not be converted again
                window.emojiPicker.discover();
                $('.emoji-picker-icon').css('top','10px');
                $('.emoji-picker-icon').css('opacity','0.5');
                $('.emoji-menu .emoji-items-wrap').css('height','200px');
                $('.emoji-menu .emoji-items-wrap').css('overflow','auto');
            });
        });
    </script>
    <script type="text/javascript">
        // document.getElementById('MYimage_uploaded_file').addEventListener('change', readURL, true);
        // function readURL(){
        //
        //     var file = document.getElementById("MYimage_uploaded_file").files[0];
        //     var reader = new FileReader();
        //     reader.onloadend = function(){
        //         document.getElementById('MyImagePrivew').src =  reader.result ;
        //         document.getElementById('uploaded_image_name').value =  reader.result ;
        //
        //     }
        //     if(file){
        //         reader.readAsDataURL(file);
        //     }else{
        //     }
        // }
    </script>
@endsection


