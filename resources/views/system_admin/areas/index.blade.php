@extends('layouts.admin')

@php

    $Disname='المدن و الأحياء';

    $icon='fas fa-globe';
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
                                @cando('add','areas')
                                <li class="m-portlet__nav-item">

                                    <a href="{{route('system.areas.create')}}" class="m-portlet__nav-link btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                        <i class="fa fa-plus"></i>
                                        <span>إضافة مدينة أو حي</span>
                                    </a>
                                </li>
                                @endcando

                            </ul>
                        </div>


                    </div>
                    <div class="m-portlet__body">

                        @if(isset($out) && count($out) > 0)

                            @foreach($out as $a)
                            <div class="productItem_country">
                                @cando('delete','areas')
                                <?php if ($a->can_del) { ?>
                                <button class="btn-del-without delaps del_country"
                                        data-id="<?= $a->id ?>"
                                        data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                        data-url="{{route('system.areas.delete_country')}}"
                                        data-token="<?= csrf_token() ?>"
                                        title="حذف"><i class="fa fa-trash"></i>
                                </button>
                                <?php } ?>
                                @endcando
                                    @cando('edit','areas')
                                        <a class="editaps " href="{{route('system.areas.update',[$a->id,1])}}"
                                                data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                title="تعديل">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                @if($delivery_price_type == 1)
                                <a class="editaps-prices " href="{{route('system.areas.edit_prices',[$a->id,1])}}"
                                   data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                   title="تعديل أسعار التوصيل">
                                    <i class="fas fa-map-marked-alt"></i>
                                </a>
                                @endif
                                    @endcando
                                <div class="titleww">
                                    <p><?= $a->name_ar ?> - <?= $a->name_en ?></p>

                                </div>

                                @if(count($a->divisions))
                                    <div class="areas">
                                        @foreach( $a->divisions as $d)
                                            <div class="productItem_country" style="width: 100%;height: unset!important;">
                                                @cando('delete','areas')
                                                <?php if ($d->can_del) { ?>
                                                <button class="btn-del-without delaps del_country"
                                                        data-id="<?= $d->id ?>"
                                                        data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                        data-url="{{route('system.areas.delete_division')}}"
                                                        data-token="<?= csrf_token() ?>"
                                                        title="حذف"><i class="fa fa-trash"></i>
                                                </button>
                                                <?php } ?>
                                                @endcando
                                                @cando('edit','areas')
                                                <a class="editaps " href="{{route('system.areas.update',[$d->id,2])}}"
                                                   data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                   title="تعديل">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endcando
                                                <div class="titleww">
                                                    <p><?= $d->name_ar ?></p>

                                                </div>
                                                <?php
                                                foreach ($d->areas as $b) { ?>

                                                <div class="productItem">
                                                    @cando('delete','areas')
                                                    <?php if ($b->can_del) { ?>
                                                    <button class="btn-del-without delaps"
                                                            data-id="<?= $b->id ?>"
                                                            data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                            data-url="{{route('system.areas.delete_city')}}"
                                                            data-token="<?= csrf_token() ?>"
                                                            title="حذف"><i class="fa fa-trash"></i>
                                                    </button>
                                                    <?php } ?>
                                                    @endcando
                                                    @cando('edit','areas')
                                                    <a class="editaps " href="{{route('system.areas.update',[$b->id,3])}}"
                                                       data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                       title="تعديل">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @endcando
                                                    <p><?= $b->name_ar ?> - <?= $b->name_en ?></p>
                                                </div>

                                                <?php } ?>
                                            </div>
                                        @endforeach


                                        <div class="clearfix"></div>
                                    </div>
                                @else
                                    <div class="areas">
                                        <?php
                                        foreach ($a->areas as $b) { ?>

                                        <div class="productItem">
                                            @cando('delete','areas')
                                            <?php if ($b->can_del) { ?>
                                            <button class="btn-del-without delaps"
                                                    data-id="<?= $b->id ?>"
                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                    data-url="{{route('system.areas.delete_city')}}"
                                                    data-token="<?= csrf_token() ?>"
                                                    title="حذف"><i class="fa fa-trash"></i>
                                            </button>
                                            <?php } ?>
                                            @endcando
                                            @cando('edit','areas')
                                            <a class="editaps " href="{{route('system.areas.update',[$b->id,3])}}"
                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                               title="تعديل">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            @endcando
                                            <p><?= $b->name_ar ?> - <?= $b->name_en ?></p>
                                        </div>

                                        <?php } ?>

                                        <div class="clearfix"></div>
                                    </div>
                                @endif
                            </div>


                        @endforeach


                            <div class="clearfix"></div>
                            <?php
                            $cc = \App\Models\Area::doesntHave('gov')->get();
                            if (count($cc) != 0) {
                            ?>
                            <div class="productItem_country" style="width: 100%;">


                                <div class="titleww">
                                    <p>مجهول</p>

                                </div>

                                <div class="areas">
                                    <?php
                                    $cc = \App\Models\Area::doesntHave('area')->get();
                                    foreach ($cc as $b) { ?>
                                    <div class="productItem">
                                        @cando('edit','areas')
                                        <?php if ($b->can_del) { ?>
                                        <button class="btn-del-without delaps"
                                                data-id="<?= $b->id ?>"
                                                data-skin="dark" data-tooltip="m-tooltip" data-placement="top"
                                                data-url="{{route('system.areas.delete_city')}}"
                                                data-token="<?= csrf_token() ?>"
                                                title="حذف"><i class="fa fa-trash"></i>
                                        </button>
                                        <?php } ?>
                                        @endcando
                                        <p><?= $b->name ?> - <?= $b->name_en ?></p>
                                    </div>

                                    <?php } ?>


                                    <div class="clearfix"></div>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                                <div class="clearfix"></div>

                            <?php }?>
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
@endsection

@section('custom_scripts')

    <style>


        /* width */
        .productItem_country .areas::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        .productItem_country .areas::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .productItem_country .areas::-webkit-scrollbar-thumb {
            background: #0ED8CA;
        }

        /* Handle on hover */
        .productItem_country .areas::-webkit-scrollbar-thumb:hover {
            background: #0ED8CA;
        }

        .delaps {
            position: absolute;
            top: 8px;
            left: 10px;
            color: #FF4A4A!important;
            border: 0;
            background: #ece8e8;
            font-size: 16px;
            padding: 5px 5px 5px 5px;
            width: 30px;
            height: 30px;
            border-radius: 20px !important;
            cursor: pointer;
        }
        .delaps i{

            font-size: 16px !important;
            display: block;

        }

        .addaps{
            position: absolute;
            top: 0px;
            left: 0px;
            color: rgba(39, 51, 71, 0.86);!important;
            border: 0;
            background: #ece8e8;
            font-size: 16px;
            padding: 0px 10px 5px 5px;
            border-radius: 0 20px 20px 0 !important;
            cursor: pointer;
        }

        .addaps i{

            display: block;
            font-size: 16px !important;

        }

        .editaps {
            position: absolute;
            top: 8px;
            right: 10px;
            padding: 5px 5px 5px 5px;
            border-radius: 20px !important;
            color: #00152A;
            border: 0;
            background: #ece8e8;
            font-size: 16px;
            cursor: pointer;

        }
        .editaps i{
            display: block;
            font-size: 16px !important;
        }
        .editaps-prices {
            position: absolute;
            top: 8px;
            right: 50px;
            padding: 5px 5px 5px 5px;
            border-radius: 20px !important;
            color: rgba(39, 51, 71, 0.86);
            border: 0;
            background: #ece8e8;
            font-size: 16px;
            cursor: pointer;

        }
        .editaps-prices i{
            display: block;
            font-size: 16px !important;
        }

        .productItem {
            width: 48%;
            height: 48px;
            background: #fff;
            box-shadow: 0px 0px 10px 0px #cccbcb;
            position: relative;
            display: block;
            float: right;
            margin: 10px 1%;
            border: 2px solid #ececec;
            overflow:hidden;
            border-radius: 30px;
            padding: 0 36px;
        }
        .productItem_country {
            width: 49%;
            height: 250px;
            background: #fff;
            box-shadow: 0px 0px 10px 0px #c8c8c8;
            position: relative;
            display: block;
            float: right;
            margin: 10px 0.5%;
            border: 2px solid #eceaea;
            overflow: hidden;
            border-radius: 20px;
        }

        @media screen and (max-width: 768px) {

            .productItem {
                width: 98% !important;
            }
            .productItem_country {
                width: 99% !important;
            }

        }
        .productItem input {
            width: 100%;
            height: 43px;
        }



        .productItem_country .titleww input {
            width: 100%;
            height: 43px;
        }

        .productItem2 {

            width: 48px;
            height: 48px;
            background: #fff;
            box-shadow: 0px 0px 10px 0px #c5c3c3;
            position: relative;
            display: block;
            float: right;
            margin: 10px 0.8%;
            font-size: 30px;
            border: 2px solid #e7e7e7;
            line-height: 48px !important;
            text-align: center;
            padding: 0;
            cursor: pointer;
            border-radius: 24px;
            overflow: hidden;

        }
        .productItem3 {

            min-width: 48px;
            height: 48px;
            background: #fff;
            box-shadow: 0px 0px 10px 0px #c5c3c3;
            position: relative;
            display: block;
            float: right;
            margin: 10px 0.8%;
            font-size: 20px;
            border: 2px solid #e7e7e7;
            line-height: 40px !important;
            text-align: center;
            cursor: pointer;
            border-radius: 24px;
            overflow: hidden;
            padding: 0 10px;
            color: #439e04;

        }
        .productItem2 i{

            font-size: 30px !important;

        }

        .productItem p {
            padding: 0 10px;
            margin: 0;
            text-align: center;
            font-size: 16px;
            line-height: 40px;
            color: #423f3f;
            font-weight: 600;
        }

        .productItem_country .titleww p {
            padding: 5px 20px;
            margin: 0;
            margin-top: 0px;
            text-align: center;
            font-size: 14px;
            line-height: 36px;
            color: #423f3f;
            background: #fcfcfc;
            height: 50px;
        }

        .productItem_country .areas {
            padding: 15px 10px;
            margin: 0;
            text-align: center;
            font-size: 16px;
            line-height: 40px;
            background: #fff;
            font-weight: 600;
            height: 200px;
            overflow: auto;
        }

        .w50 {
            width: 48% !important;
            float: right;
        }

        .f22 {
            font-size: 22px !important;
        }
        .h38{
            height: 38px;
        }
    </style>

    <script>
        function myTrim(x) {
            return x.replace(/^\s+|\s+$/gm,'');
        }

        $(function () {
            $('#areas123').addClass('active').find('.arrow').addClass('open');

            $('#AddNewCountry').click(function () {
                $(this).before(
                    '<div class="productItem new">\n' +
                    '<button class="btn-add addaps addCountry" data-aaa="tooltip" title="حفظ"><i class="fa fa-check"></i></button>\n' +
                    '<input type="text" name="name" class="form-control w50 newName">\n' +
                    '<input type="text" name="name_en" class="form-control w50 newName_en">\n' +
                    '<div class="clearfix"></div>'+
                    '</div>');
            });
            $('body').on('click', '.AddNewCity', function () {
                var country = $(this).data('country');
                $(this).before(
                    '<div class="productItem new">\n' +
                    '<button class="btn-add addaps addCity" data-aaa="tooltip" title="حفظ"><i class="fa fa-check"></i></button>\n' +
                    '<input type="text" name="name" class="form-control w50 newName">\n' +
                    '<input type="text" name="name_en" class="form-control w50 newName_en">\n' +
                    '<input type="hidden" name="country" value="' + country + '" class="country_ID">\n' +
                    '<div class="clearfix"></div>'+
                    '</div>');
            });
            $('body').on('click', '.addCountry', function () {
                var name = myTrim($(this).parent('.new').find('.newName').val());
                var name_en = myTrim($(this).parent('.new').find('.newName_en').val());
                var thisbtn = $(this);
                if (name == ''||name_en == '') {
                    alert('ادخل اسم');
                    return;
                }
                var url = '{{route('system.areas.add_country')}}';
                var token = '<?= csrf_token()?>';
                $.post(url,
                    {
                        _token: token,
                        name: name,
                        name_en: name_en,
                    },
                    function (data, status) {
                        if (data.done == 'true') {
                            thisbtn.parent('.new').before(data.out);
                            thisbtn.parent('.new').remove()
                        } else {
                        }
                    });
            });

            $('body').on('click', '.addCity', function () {
                var name = myTrim($(this).parent('.new').find('.newName').val());
                var name_en = myTrim($(this).parent('.new').find('.newName_en').val());
                var country = $(this).parent('.new').find('.country_ID').val();
                var thisbtn = $(this);
                if (name == ''||name_en == '') {
                    alert('ادخل اسم');
                    return;

                }
                var url = '{{route('system.areas.add_city')}}';
                var token = '<?= csrf_token()?>';
                $.post(url,
                    {
                        _token: token,
                        name: name,
                        name_en: name_en,
                        country: country,
                    },
                    function (data, status) {
                        if (data.done == 'true') {
                            thisbtn.parent('.new').before(data.out);
                            thisbtn.parent('.new').remove()
                        } else {
                        }
                    });
            });


            $('body').on('click', '.edit_country', function () {
                var name = $(this).data('name');
                var name_en = $(this).data('name_en');
                var id = $(this).data('id');
                $(this).parent('.productItem_country').find('.titleww').before(
                    '<div class="new">\n' +
                    '<button class="addaps btn-edit-country f22" data-aaa="tooltip" title="حفظ"><i class="fa fa-check"></i></button>\n' +
                    '<input type="text" name="name" value="' + name + '" class=" w50 form-control w50 h38 newName">\n' +
                    '<input type="text" name="name_en"  value="' + name_en + '" class="form-control w50 h38 newName_en">\n' +

                    '<input type="hidden" name="id" value="' + id + '"  class="form-control ID">\n' +
                    '<div class="clearfix"></div>'+
                    '</div>');
                $(this).parent('.productItem_country').find('.titleww').find('p').remove();
                $(this).remove();

            });
            $('body').on('click', '.edit_city', function () {
                var name = $(this).data('name');
                var name_en = $(this).data('name_en');
                var id = $(this).data('id');
                $(this).parent('.productItem').before(
                    '<div class="productItem new">\n' +
                    '<button class="addaps btn-edit-city" data-aaa="tooltip" title="حفظ"><i class="fa fa-check"></i></button>\n' +
                    '<input type="text" name="name" value="' + name + '" class="form-control w50 newName">\n' +
                    '<input type="text" name="name_en"  value="' + name_en + '" class="form-control w50 newName_en">\n' +
                    '<input type="hidden" name="id" value="' + id + '"  class="form-control ID">\n' +
                    '<div class="clearfix"></div>'+
                    '</div>');
                $(this).parent('.productItem').remove();


            });

            $('body').on('click', '.btn-edit-country', function () {
                var name = myTrim($(this).parent('.new').find('.newName').val());
                var name_en = myTrim($(this).parent('.new').find('.newName_en').val());
                var id = $(this).parent('.new').find('.ID').val();
                var thisbtn = $(this);
                if (name == ''||name_en == '') {
                    alert('ادخل اسم');
                    return;

                }
                var url = '{{route('system.areas.edit_country')}}';
                var token = '<?= csrf_token()?>';
                $.post(url,
                    {
                        _token: token,
                        name: name,
                        name_en: name_en,
                        id:id
                    },
                    function (data, status) {
                        if (data.done == 'true') {
                            thisbtn.parent('.new').parent().before(data.out);
                            thisbtn.parent('.new').parent().remove()
                        } else {
                        }
                    });
            });

            $('body').on('click', '.btn-edit-city', function () {
                var name = myTrim($(this).parent('.new').find('.newName').val());
                var name_en = myTrim($(this).parent('.new').find('.newName_en').val());
                var id = $(this).parent('.new').find('.ID').val();
                var thisbtn = $(this);
                if (name == ''||name_en == '') {
                    alert('ادخل اسم');
                    return;

                }
                var url = '{{route('system.areas.edit_city')}}';
                var token = '<?= csrf_token()?>';
                $.post(url,
                    {
                        _token: token,
                        name: name,
                        name_en: name_en,
                        id:id
                    },
                    function (data, status) {
                        if (data.done == 'true') {
                            thisbtn.parent('.new').before(data.out);
                            thisbtn.parent('.new').remove()
                        } else {
                        }
                    });
            });


            $("body").on('click', '.btn-del-without',
                function () {
                    var r = confirm("هل تريد بالتأكيد حذف العنصر");
                    if (r == true) {
                        var Id = $(this).data('id');
                        var url = $(this).data('url');
                        var token = $(this).data('token');
                        var btn = $(this);
                        $.post(url,
                            {
                                _token: token,
                                id: Id,
                            },
                            function (data, status) {
                                if (data.done == 'true') {
                                    btn.parent('.productItem').remove();
                                    btn.parent('.productItem_country').remove();
                                } else {
                                    alert(data.mess)
                                }
                            });
                    }
                })
        })
    </script>
@endsection
