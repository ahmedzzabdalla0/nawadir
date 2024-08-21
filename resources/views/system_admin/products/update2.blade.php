@extends('layouts.admin')

@php
    $Disname='المنتجات';
@endphp
@section('title',  $Disname)
@section('head')
    <style>
        .discount-ratio-cell{
            display: none;
        }
        .discount-price-cell{
            display: none;
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
                        <a href="{{route('system.products.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">تعديل</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{route('system.products.do.update',$out->id)}}" id="form" method="post">
                    <!--begin::Portlet-->
                    <div class="m-portlet m-portlet--tabs">
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
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">

                                        <button type="button" id="submit_replace" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                            <i class="fa fa-check"></i>
                                            <span>تعديل</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="m-portlet__body">

                            @csrf

                            <div class="row">

                                <div class="col-md-6">
                                    @component('components.input',['data'=>$out->name_ar,'name'=>'name_ar','text'=>'الاسم باللغة العربية','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                                <div class="col-md-6">
                                    @component('components.input',['data'=>$out->name_en,'name'=>'name_en','text'=>'Name in English','placeholder'=>'Enter the name','icon'=>'fa-user-alt'])
                                    @endcomponent
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-6">
                                    @component('components.input',['data'=>$out->real_price,'type'=>'number','min'=>0,'name'=>'price','text'=>'السعر','icon'=>'fa-dollar-sign'])
                                    @endcomponent

                                </div>
                                <div class="col-md-6">
                                    @component('components.input',['data'=>$out->discount_ratio,'name'=>'ratio','text'=>'نسبة الخصم تترك 0 اذا لا يوجد خصم','icon'=>'fa-percent'])
                                    @endcomponent

                                </div>
                                @if($out->type == 1)
                                  <div class="col-md-6">
                                    @component('components.switch',['name'=>'type','text'=>'يحتاج الي تقطيع','data'=>'1'])
                                    @endcomponent
                                </div>
                                @else
                                 <div class="col-md-6">
                                    @component('components.switch',['name'=>'type','text'=>'يحتاج الي تقطيع','data'=>'0'])
                                    @endcomponent
                                </div>
                                
                                @endif
                                <div class="w-100"></div>
                            </div>

                            <ul class="nav nav-tabs  m-tabs-line" role="tablist" style="padding: 10px;">
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_1_1" role="tab">البيانات الاساسية</a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_1_2" role="tab">التفاصيل</a>
                                </li>
                                <li class="nav-item m-tabs__item">
                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_1_3" role="tab">الصور</a>
                                </li>
                                @if($config['product_properties']==1)
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_1_4" role="tab">الخصائص</a>
                                    </li>
                                @endif
                            </ul>
                            <div class="tab-content" style="padding: 10px;">
                                <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">


                                    <div class="row">
                                        <div class="w-100"></div>

                                        <div class="col-md-6">
                                            @component('components.select-default',['data'=>$out->category_id,'name'=>'category_id','text'=>'التصنيف','select'=>$categories,'add_url'=>route('system.categories.createJson')])
                                            @endcomponent

                                        </div>
                                        @if($delivery_price_type == 3)
                                            <div class="col-md-6" style="display: none">
                                                @component('components.input',['data'=>$out->delivery_price,'type'=>'number','name'=>'delivery_price','text'=>'سعر الشحن','icon'=>'fa-dollar-sign'])
                                                @endcomponent

                                            </div>
                                        @endif
                                    </div>


                                </div>
                                <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">

                                    <div class="row">
                                        <div class="w-100"></div>
                                        <div class="col-md-6">
                                            @component('components.area_editor',['data'=>$out->details_ar,'name'=>'details_ar','text'=>'التفاصيل'])
                                            @endcomponent

                                        </div>
                                        <div class="col-md-6">
                                            @component('components.area_editor',['data'=>$out->details_en,'name'=>'details_en','text'=>'Details'])
                                            @endcomponent

                                        </div>

                                        <div class="w-100"></div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="m_tabs_1_3" role="tabpanel">

                                    <div class="row">
                                        <div class="col-md-12">
                                            @component('components.uploadNewUpdate',['add_route'=>'system.products.upload_image','path'=>'system_admin.products.images','out'=>$out])
                                            @endcomponent
                                        </div>


                                    </div>

                                </div>

                                <div class="tab-pane" id="m_tabs_1_4" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="w-100"></div>
                                                <div class="col-md-12" id="size_category">
                                                    <div>
                                                        <a class="btn btn-sm btn-success" href="javascript:;" id="add_more_size">
                                                            <i class="fa fa-plus"></i>
                                                            <span>اضافة حجم جديد</span>
                                                        </a>
                                                    </div>
                                                    <br>
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">الحجم</th>
                                                            <th class="text-center">السعر</th>
                                                            <th class="text-center discount-ratio-cell">الخصم</th>
                                                            <th class="text-center discount-price-cell">السعر بعد الخصم</th>
                                                            <th class="text-center">الاعدادات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="size_cont">
                                                        @if($out->category_id == 1 && count($out->variants))
                                                            @php $j =0; @endphp
                                                            @foreach($out->variants as $variant)
                                                                <tr>


                                                                    <td class="text-center">
                                                                        <select class="m-input m-input--pill m-input--air size_id" name="size_id[]" required>
                                                                            @foreach($sizes as $size)
                                                                                <option value="{{$size->id}}" {{$variant->size_id == $size->id?'selected':''}}>{{$size->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input name="size_unit_price[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air size_unit_price"
                                                                               placeholder="أدخل سعر الوحدة" min="1"
                                                                               value="{{$variant->price }}" required/>
                                                                    </td>
                                                                    <td class="text-center discount-ratio-cell">
                                                                        <input name="discount_ratio_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value"  min="1"
                                                                               value="0"/>
                                                                    </td>
                                                                    <td class="text-center discount-price-cell">
                                                                        <input name="discount_price_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value" min="1"
                                                                               value="0"/>
                                                                    </td>
                                                                    <td>
                                                                        @if($j>0)
                                                                            <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_price"><i class="fa fa-times"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @php $j++; @endphp
                                                            @endforeach
                                                        @else
                                                            @if(old('size_id'))
                                                                @for($i = 0;$i<count(old('size_id'));$i++)
                                                                    <tr>


                                                                        <td class="text-center">
                                                                            <select class="m-input m-input--pill m-input--air size_id" name="size_id[]" required>
                                                                                @foreach($sizes as $size)
                                                                                    <option value="{{$size->id}}" {{old('size_id')[$i] == $size->id?'selected':''}}>{{$size->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <input name="size_unit_price[]"
                                                                                   type="number"   class="form-control m-input m-input--pill m-input--air size_unit_price"
                                                                                   placeholder="أدخل سعر الوحدة" min="1"
                                                                                   value="{{old('size_unit_price') && old('size_unit_price')[$i] ?old('size_unit_price')[$i]:'' }}" required/>
                                                                        </td>
                                                                        <td class="text-center discount-ratio-cell">
                                                                            <input name="discount_ratio_value[]" disabled
                                                                                   type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value"  min="1"
                                                                                   value="{{old('discount_ratio_value') && old('discount_ratio_value')[$i] ?old('discount_ratio_value')[$i]:'' }}"/>
                                                                        </td>
                                                                        <td class="text-center discount-price-cell">
                                                                            <input name="discount_price_value[]" disabled
                                                                                   type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value" min="1"
                                                                                   value="{{old('discount_price_value') && old('discount_price_value')[$i] ?old('discount_price_value')[$i]:'' }}"/>
                                                                        </td>
                                                                        <td>
                                                                            @if($i>0)
                                                                                <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_price"><i class="fa fa-times"></i></a>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                            @else
                                                                <tr>


                                                                    <td class="text-center">
                                                                        <select class="m-input m-input--pill m-input--air size_id" name="size_id[]" required>
                                                                            @foreach($sizes as $size)
                                                                                <option value="{{$size->id}}">{{$size->name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input name="size_unit_price[]"
                                                                               type="number" min="1"   class="form-control m-input m-input--pill m-input--air size_unit_price"
                                                                               placeholder="أدخل سعر الوحدة"
                                                                               value="" required/>
                                                                    </td>
                                                                    <td class="text-center discount-ratio-cell">
                                                                        <input name="discount_ratio_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value"
                                                                               value="0"/>
                                                                    </td>
                                                                    <td class="text-center discount-price-cell">
                                                                        <input name="discount_price_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value"
                                                                               value="0"/>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            @endif
                                                        @endif


                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-12" id="weight_category">
                                                    <div>
                                                        <a class="btn btn-sm btn-success" href="javascript:;" id="add_more_weight">
                                                            <i class="fa fa-plus"></i>
                                                            <span>اضافة وزن جديد</span>
                                                        </a>
                                                    </div>
                                                    <br>
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center">الوزن(من-الى)</th>
                                                            <th class="text-center">السعر</th>
                                                            <th class="text-center discount-ratio-cell">الخصم</th>
                                                            <th class="text-center discount-price-cell">السعر بعد الخصم</th>
                                                            <th class="text-center">الاعدادات</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="weight_cont">
                                                        @if($out->category_id != 1 && count($out->variants))
                                                            @php $j =0; @endphp
                                                            @foreach($out->variants as $variant)
                                                                <tr>


                                                                    <td class="text-center">
                                                                        <input name="weight_from[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air weight_from"
                                                                               placeholder="أدخل الوزن" min="1"
                                                                               value="{{$variant->weight }}" required/>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input name="weight_to[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air weight_to"
                                                                               placeholder="أدخل الوزن" min="1"
                                                                               value="{{$variant->weight_to }}" required/>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input name="weight_unit_price[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air weight_unit_price"
                                                                               placeholder="أدخل سعر الوحدة" min="1"
                                                                               value="{{$variant->price }}" required/>
                                                                    </td>
                                                                    <td class="text-center discount-ratio-cell">
                                                                        <input name="discount_ratio_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value"  min="1"
                                                                               value="0"/>
                                                                    </td>
                                                                    <td class="text-center discount-price-cell">
                                                                        <input name="discount_price_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value" min="1"
                                                                               value="0"/>
                                                                    </td>
                                                                    <td>
                                                                        @if($j>0)
                                                                            <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_price"><i class="fa fa-times"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                @php $j++; @endphp
                                                            @endforeach
                                                        @else
                                                        @if(old('weight_from'))
                                                            @for($i = 0;$i<count(old('weight_from'));$i++)
                                                                <tr>


                                                                    <td class="text-center">
                                                                        <input name="weight_from[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air weight_from"
                                                                               placeholder="أدخل الوزن" min="1"
                                                                               value="{{old('weight_from') && old('weight_from')[$i] ?old('weight_from')[$i]:'' }}" required/>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input name="weight_to[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air weight_to"
                                                                               placeholder="أدخل الوزن" min="1"
                                                                               value="{{old('weight_to') && old('weight_to')[$i] ?old('weight_to')[$i]:'' }}" required/>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <input name="weight_unit_price[]"
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air weight_unit_price"
                                                                               placeholder="أدخل سعر الوحدة" min="1"
                                                                               value="{{old('weight_unit_price') && old('weight_unit_price')[$i] ?old('weight_unit_price')[$i]:'' }}" required/>
                                                                    </td>
                                                                    <td class="text-center discount-ratio-cell">
                                                                        <input name="discount_ratio_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value"  min="1"
                                                                               value="{{old('discount_ratio_value') && old('discount_ratio_value')[$i] ?old('discount_ratio_value')[$i]:'' }}"/>
                                                                    </td>
                                                                    <td class="text-center discount-price-cell">
                                                                        <input name="discount_price_value[]" disabled
                                                                               type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value" min="1"
                                                                               value="{{old('discount_price_value') && old('discount_price_value')[$i] ?old('discount_price_value')[$i]:'' }}"/>
                                                                    </td>
                                                                    <td>
                                                                        @if($i>0)
                                                                            <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_price"><i class="fa fa-times"></i></a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        @else
                                                            <tr>


                                                                <td class="text-center">
                                                                    <input name="weight_from[]"
                                                                           type="number"   class="form-control m-input m-input--pill m-input--air weight_from"
                                                                           placeholder="أدخل الوزن" min="1"
                                                                           value="" required/>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input name="weight_to[]"
                                                                           type="number"   class="form-control m-input m-input--pill m-input--air weight_to"
                                                                           placeholder="أدخل الوزن" min="1"
                                                                           value="" required/>
                                                                </td>
                                                                <td class="text-center">
                                                                    <input name="weight_unit_price[]"
                                                                           type="number" min="1"   class="form-control m-input m-input--pill m-input--air weight_unit_price"
                                                                           placeholder="أدخل سعر الوحدة"
                                                                           value="" required/>
                                                                </td>
                                                                <td class="text-center discount-ratio-cell">
                                                                    <input name="discount_ratio_value[]" disabled
                                                                           type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value"
                                                                           value="0"/>
                                                                </td>
                                                                <td class="text-center discount-price-cell">
                                                                    <input name="discount_price_value[]" disabled
                                                                           type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value"
                                                                           value="0"/>
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                        @endif

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="w-100"></div>


                                                <div class="clearfix"></div>

                                            </div>

                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                            </div>


                        </div>
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



        });


        $(document).ready(function () {
            $('#submit_replace').click(function(){
                var flag = false;
                if($('#category_id').val()==1){
                    if($('.size_unit_price').length == 1 && $('input.size_unit_price').val() != $('#price').val()){
                        swal.fire({
                            'title':'خطأ في السعر',
                            'text':'يجب أن يكون السعر الخاص بالحجم مطابق للسعر المدخل',
                            'type':'warning',
                            'confirmButtonText':'تم!',
                        });
                    }else{
                        flag = true;
                    }
                }else{
                    if($('.weight_unit_price').length == 1 && $('input.weight_unit_price').val() != $('#price').val()){

                        swal.fire({
                            'title':'خطأ في السعر',
                            'text':'يجب أن يكون السعر الخاص بالوزن مطابق للسعر المدخل',
                            'type':'warning',
                            'confirmButtonText':'تم!',
                        });
                    }else{
                        flag = true;
                    }
                }
                if(flag){
                    $('#form').submit();
                }
            });
            checkCategory($('#category_id').val());
            $('#category_id').on('change',function(){
                checkCategory($(this).val());
            });

            function checkCategory(id){
                if(id == 1){
                    $('#size_category').show();
                    $('#weight_category').hide();
                    $( "input[name='weight_from[]']" ).attr( "required",false );
                    $( "input[name='weight_to[]']" ).attr( "required",false );
                    $( "input[name='weight_unit_price[]']" ).attr( "required",false );

                }else{
                    $('#size_category').hide();
                    $('#weight_category').show();
                    $( "input[name='size_id[]']" ).attr( "required",false );
                    $( "input[name='size_unit_price[]']" ).attr( "required",false );

                }
            }

            $(document).on('click','#add_more_size', function(e) {
                options = "@forelse($sizes as $size)\n" +
                    " <option value=\"{{ $size->id }}\">{{ $size->name }}</option>\n" +
                    "  @empty\n" +
                    "  @endforelse";
                options_count = parseInt('{{count($sizes)}}');
                if($('select.size_id').length < options_count){
                    var inputs = '<tr>\n' +
                        '                                                                    <td class="text-center">\n' +
                        '                                                                        <select class="m-input m-input--pill m-input--air size_id" name="size_id[]" required>'+
                        options+
                        '</select>\n' +
                        '                                                                    </td>\n' +
                        '                                                                    <td class="text-center">\n' +
                        '                                                                        <input type="number" class="form-control m-input m-input--pill size_unit_price" placeholder="أدخل سعر الوحدة"\n' +
                        '                                                                            required   name="size_unit_price[]" min="1" value="">\n' +
                        '                                                                    </td>\n' +
                        '<td class="text-center discount-ratio-cell">\n' +
                        '                                                                    <input name="discount_ratio_value[]" disabled\n' +
                        '                                                                           type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value" \n' +
                        '                                                                           value="0"/>\n' +
                        '                                                                </td>\n' +
                        '                                                                <td class="text-center discount-price-cell">\n' +
                        '                                                                    <input name="discount_price_value[]" disabled\n' +
                        '                                                                           type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value" \n' +
                        '                                                                           value="0"/>\n' +
                        '                                                                </td>'+
                        '                                                                    <td class="text-center">\n' +
                        '                                                                        <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_price" \n' +
                        '                                                                               ><i class="fa fa-times"></i></a>\n' +
                        '                                                                    </td>\n' +
                        '                                                                </tr>';
                    $('#size_cont').append(inputs);
                    $( "input[name='size_id[]']" ).attr( "required","required" );
                    $( "input[name='size_unit_price[]']" ).attr( "required","required" );
                    var arr = $('select.size_id').not(":last").map(function(){
                        return this.value
                    }).get();
                    $("select.size_id:last option").each(function(){
                        if (arr.includes($(this).attr('value'))) {
                            $(this).attr("disabled", "disabled");
                        }
                    });
                    $( "select.size_id" ).last().niceSelect();
                    checkDiscount();
                }else{
                    swal.fire({
                        'title':'لا يمكن تجاوز عدد الأحجام المتاحة',
                        'text':'لا يمكن تجاوز عدد الأحجام المتاحة',
                        'type':'warning',
                        'confirmButtonText':'تم'
                    });
                }

            });
            $(document).on('click','#add_more_weight', function(e) {

                var inputs = '<tr>\n' +
                    '                                                                    <td class="text-center">\n' +
                    '                                                                        <input type="number" class="form-control m-input m-input--pill" placeholder="أدخل الوزن"\n' +
                    '                                                                            required   name="weight_from[]" min="1" value="">\n' +
                    '                                                                    </td>\n' +
                    '                                                                    <td class="text-center">\n' +
                    '                                                                        <input type="number" class="form-control m-input m-input--pill" placeholder="أدخل الوزن"\n' +
                    '                                                                            required   name="weight_to[]" min="1" value="">\n' +
                    '                                                                    </td>\n' +
                    '                                                                    <td class="text-center">\n' +
                    '                                                                        <input type="number" class="form-control m-input m-input--pill weight_unit_price" placeholder="أدخل سعر الوحدة"\n' +
                    '                                                                            required   name="weight_unit_price[]" min="1" value="">\n' +
                    '                                                                    </td>\n' +
                    '<td class="text-center discount-ratio-cell">\n' +
                    '                                                                    <input name="discount_ratio_value[]" disabled\n' +
                    '                                                                           type="number"   class="form-control m-input m-input--pill m-input--air discount_ratio_value" \n' +
                    '                                                                           value="0"/>\n' +
                    '                                                                </td>\n' +
                    '                                                                <td class="text-center discount-price-cell">\n' +
                    '                                                                    <input name="discount_price_value[]" disabled\n' +
                    '                                                                           type="number"   class="form-control m-input m-input--pill m-input--air discount_price_value" \n' +
                    '                                                                           value="0"/>\n' +
                    '                                                                </td>'+
                    '                                                                    <td class="text-center">\n' +
                    '                                                                        <a href="javascript:;" class="btn btn-sm btn-outline-danger delete_price" \n' +
                    '                                                                               ><i class="fa fa-times"></i></a>\n' +
                    '                                                                    </td>\n' +
                    '                                                                </tr>';
                $('#weight_cont').append(inputs);
                $( "input[name='weight_from[]']" ).attr( "required","required" );
                $( "input[name='weight_to[]']" ).attr( "required","required" );
                $( "input[name='weight_unit_price[]']" ).attr( "required","required" );
                checkDiscount();
            });

            $(document).on('click','.delete_price', function(e) {
                e.preventDefault();
                $(this).parent('td').parent('tr').remove();

            });
            checkDiscount();
            $(document).on('input','#ratio', function(e) {
                e.preventDefault();
                checkDiscount();

            });
            $(document).on('input','#weight_category .weight_unit_price', function(e) {
                e.preventDefault();
                checkDiscount();

            });
            $(document).on('input','#weight_category .size_unit_price', function(e) {
                e.preventDefault();
                checkDiscount();

            });
            function checkDiscount(){
                var ratio = $('#ratio').val();
                if(ratio > 0 && ratio<=100){
                    $('.discount-ratio-cell').css('display','table-cell');
                    $('.discount_ratio_value').val(ratio);
                    $('.discount-price-cell').css('display','table-cell');
                    $("#weight_category .discount-ratio-cell").each(function() {
                        var price= $(this).prev().children('#weight_category .weight_unit_price').val();
                        if(price>0){
                            const formatter = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            });
                            var new_price = price - formatter.format(price*ratio/100);
                            $(this).next().children('#weight_category .discount_price_value').val(formatter.format(new_price));
                        }
                    });
                    $("#size_category .discount-ratio-cell").each(function() {
                        var price= $(this).prev().children('#size_category .size_unit_price').val();
                        if(price>0){
                            const formatter = new Intl.NumberFormat('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            });
                            var new_price = price - formatter.format(price*ratio/100);
                            $(this).next().children('#size_category .discount_price_value').val(formatter.format(new_price));
                        }
                    });
                }else{
                    $('.discount-ratio-cell').css('display','none');
                    $('.discount_ratio_value').val(0);
                    $('.discount_price_value').val(0);
                    $('.discount-price-cell').css('display','none');
                }
            }

        });
    </script>

@endsection


