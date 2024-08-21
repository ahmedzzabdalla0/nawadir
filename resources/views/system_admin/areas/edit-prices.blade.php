@extends('layouts.admin')

@php

    $Disname='المدن و الأحياء';

@endphp

@section('title',  $Disname)


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
                        <a href="{{route('system.areas.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">تعديل أسعار التوصيل</span>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
    </div>

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

                        <form action="{{route('system.areas.do.updatePrices')}}" id="form" method="post"
                              class="form-horizontal">
                            @csrf

                            <div class="row justify-content-center">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الحي</th>
                                            <th>سعر التوصيل</th>
                                        </tr>
                                        </thead>
                                        <tbody>


                                        @foreach($out->areas as $area)
                                            <tr>

                                                <td class="LOOPIDS">{{$loop->iteration}}</td>
                                                <td style="width:40%;">
                                                    {{ $area->name }}
                                                    <input type="hidden" name="area_id[]" value="{{$area->id}}">
                                                </td>
                                                <td style="width:25%;">
                                                    <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                                        <input type="number" class="form-control m-input m-input--pill m-input--air" placeholder="سعر التوصيل"
                                                               required min="0" name="delivery_price[]" value="@old('delivery_price[]',$area->delivery_price)">
                                                        <span class="m-input-icon__icon m-input-icon__icon--left"><span><i class="fas fa-dollar-sign"></i></span></span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                                <div class="row  justify-content-center">
                                    <button type="submit" style="margin: 10px;"
                                            class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-check"></i>
                                        <span>تعديل</span>
                                    </button>
                                    <a href="{{route('system.areas.index')}}" style="margin: 10px;"
                                       class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom">
                                        <i class="flaticon-cancel"></i>
                                        <span>الغاء</span>
                                    </a>
                                </div>

                        </form>

                        <!-- END FORM-->

                    </div>
                </div>
            </div>

        </div>

    </div>




    <!-- END PAGE BASE CONTENT -->

@endsection

@section('custom_scripts')

    <script>

        $(function () {

            $('#form').validate({

                errorElement: 'div', //default input error message container

                errorClass: 'abs_error help-block has-error',

            }).init();

        })


    </script>



@endsection





