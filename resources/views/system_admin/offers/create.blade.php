@extends('layouts.admin')

@php
    $Disname='العروض';
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
                        <a href="{{route('system.offers.index')}}" class="m-nav__link">
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
                                                <i class="flaticon-cogwheel"></i>
                                            </span>
                                <h3 class="m-portlet__head-text">
                                    {{$Disname}}
                                </h3>
                            </div>
                        </div>

                    </div>
                    <div class="m-portlet__body">
                        <form action="{{route('system.offers.do.create')}}" id="form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-10 row">
                                            <div class="col-md-6">
                                                @component('components.input',['name'=>'name','text'=>'الاسم','placeholder'=>'ادخل الاسم','icon'=>'fa-user-alt'])
                                                @endcomponent
                                            </div>
                                            <div class="col-md-6">
                                                @component('components.input',['name'=>'name_en','text'=>'name','placeholder'=>'Enter the name','icon'=>'fa-user-alt'])
                                                @endcomponent
                                            </div>

                                            <div class="w-100"></div>
                                            <div class="col-md-6">
                                                @component('components.input',['name'=>'price','text'=>'سعر العرض','icon'=>'fa-dollar-sign'])
                                                @endcomponent

                                            </div>

                                            <div class="col-md-6">
                                                <label for="date_from">مدة العرض </label>

                                                <div class="input-group input-daterange">
                                                    <input type="text" readonly name="date_from" value="@old('date_from')" class="form-control m-input m-input--pill" placeholder="من تاريخ">
                                                    <input type="text" readonly name="date_to" value="@old('date_to')" class="form-control m-input m-input--pill" placeholder="الى تاريخ">

                                                </div>
                                                @show_error('date_from')
                                                @show_error('date_to')



                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @component('components.upload_image',['name'=>'image','text'=>'صورة العرض','hint'=>'400 * 400 بيكسل'])
                                            @endcomponent
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="w-100"></div>

                                        @foreach($cats as $ch)
                                            <div class="col-md-4">
                                                <div class="mycollapse" >
                                                    <div class="title"  data-toggle="collapse" data-target="#coll{{$ch->id}}">
                                                        {{$ch->name}}
                                                    </div>
                                                    <div id="coll{{$ch->id}}" class="collapse mycoll show">
                                                        <?php
                                                        $services=\App\Models\Service::where('category_id',$ch->id)->get();
                                                        ?>
                                                        @foreach($services as $c)
                                                            <label class="m-checkbox">
                                                                <input type="checkbox" name="services[]" {{is_array(old('services'))?in_array($c->id,old('services'))?'checked':'':''}} value="{{$c->id}}"> {{$c->name}}
                                                                <span></span>
                                                            </label>
                                                            <br>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach


                                    </div>

                                </div>

                                <div class="clearfix"></div>
                            </div>
                            <div class="col">
                                <button type="submit"
                                        class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                    <i class="fa fa-check"></i>
                                    <span>اضافة</span>
                                </button>
                                <a href="{{route('system.offers.index')}}"
                                   class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
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
            $('#is_participation').on('click',function () {
                if ($(this).is(':checked')) {
                    $('.part_ratio').hide();
                } else {
                    $('.part_ratio').show();
                }
            });

        })

    </script>

@endsection


