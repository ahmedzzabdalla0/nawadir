@extends('layouts.admin')

@php
    $Disname='ساعات وايام العمل';
    $icon=' fas fa-clock';

@endphp
@section('title',  $Disname)
@section('head')
    <style>
        .dayes_item {
            display: block;
            float: right;
            width: 100px;
            text-align: center;
            margin: 15px;
            background: #fbfbfb;
            padding: 15px;
            border-radius: 50% !important;
            position: relative;
            height: 100px;
            border: 1px solid #ddd;
        }

        .dayes_item .chickBTN {
            position: absolute;
            bottom: 15px;
            left: calc(50% - 10px);

        }

        .dayes_item img {
            width: 70px;
            margin: auto;
            display: block;
        }

        .dayes_item h3 {
            margin: 0;
        }

        .dateSel {
            width: 13%;
            float: right;
            display: block;
            margin: 20px 0.5%;
            position: relative;
            border: 2px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            overflow: hidden;
        }

        .dateSel .free {
            background: rgba(121, 159, 142, 0.51);
            color: #fff;
            position: absolute;
            top: 0;
            right: 0;
            display: block;
            padding: 10px;
            border-radius: 0 10px 10px 10px;
            left: 0;
            width: 100%;
        }

        .dateSel .used {
            background: rgba(156, 109, 99, 0.44);
            color: #fff;
            position: absolute;
            top: 0;
            right: 0;
            display: block;
            padding: 10px;
            border-radius: 0 10px 10px 10px;
            left: 0;
            width: 100%;

        }

        .mygreen {
            background: #7ff2844d;
        }

        .myred {
            background: rgba(242, 188, 131, 0.3);
        }

        .dateSel h3 {
            margin-top: 40px;
        }

        .dateSel .day-name {

            margin-top: 10px;
        }

        .dateSel button {
            position: absolute !important;
            right: 0;
            top: 0;
            border-radius: 10px !important;
            height: 40px;
            width: 40px;
            text-align: center;
            font-size: 18px !important;
            padding: 0 !important;
            background: rgba(151, 156, 148, 0.44);
        }

        .nav-tabs {
            margin-top: 30px;
        }

        .nav-tabs li a {
            background: #f6f4f4;
            color: #1f1f1f;
        }

        @media screen and (max-width: 998px) {
            .dateSel {
                width: 24%;
                float: right;
                display: block;
                margin: 20px 0.5%;
                position: relative;
                border: 2px solid #ddd;
                border-radius: 10px;
                padding: 10px;
                text-align: center;
                overflow: hidden;
            }
        }

        @media screen and (max-width: 660px) {
            .dateSel {
                width: 99%;
                float: right;
                display: block;
                margin: 20px 0.5%;
                position: relative;
                border: 2px solid #ddd;
                border-radius: 10px;
                padding: 10px;
                text-align: center;
                overflow: hidden;
            }

            .nav-justified{
                display: block !important;
            }
            .nav-tabs li {
                display: block;
                width: 100%;
                margin: 10px auto;
                text-align: center;
            }

            .nav-tabs li.active a {
                border-bottom: 1px solid #ddd !important;
            }

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

                    </div>
                    <div class="m-portlet__body">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <form action="{{route('system.daysandtimes.add_days')}}" method="post" id="form">
                                    @csrf



                                    <div class="col-md-12">
                                        <div class="row justify-content-center">
                                            <div class="col">
                                                <h3 style="text-align: center">الايام</h3>
                                                <small style="text-align: center;display: block;color: grey">اختر أيام العمل</small>
                                                @if($errors->has('dayes.*'))
                                                    <span style="text-align: center" class="help-block has-error"> <strong>الرجاء التأكد من اختيار يوم واحد على الاقل</strong></span>
                                                @endif
                                                @if($errors->has('dayes'))
                                                    <span style="text-align: center" class="help-block has-error"> <strong>الرجاء التأكد من اختيار يوم واحد على الاقل</strong></span>
                                                @endif
                                            </div>
                                            <div class="w-100"></div>


                                            <?php
                                            foreach ($dayes as $s) { ?>

                                            <div class="dayes_item">


                                                <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table chickBTN">
                                                    <input type="checkbox" name="dayes[]" <?= $s->used ? 'checked' : '' ? 'checked' : '' ?>
                                                    value="<?= $s->id ?>">
                                                    <span></span>
                                                </label>
                                                <h3><?= $s->name_ar ?></h3>
                                            </div>


                                            <?php } ?>
                                        </div>

                                    </div>



                                    <div class="row justify-content-center">
                                        <div class="col-md-3 col-xs-6" style="margin-top: 10px;margin-bottom: 30px;">
                                            <button type="submit"
                                                    class="btn btn-block m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                                <i class="fa fa-check"></i>
                                                <span>تعديل</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <br>
                                <form action="{{route('system.daysandtimes.add_times')}}" method="post" id="form">
                                    @csrf

                                    <div class="col-md-12">
                                        <h3 style="text-align: center">ساعات العمل</h3>
                                        <small style="text-align: center;display: block;color: grey">اختر اوقات العمل من
                                            الى
                                        </small>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            @component('components.select',['data'=>$time_from,'select'=>$times,'name'=>'time_from','text'=>'ساعات العمل من ','placeholder'=>'اختر ساعة بداية العمل'])
                                            @endcomponent
                                        </div>
                                        <div class="col-md-6">
                                            @component('components.select',['data'=>$time_to,'select'=>$times,'name'=>'time_to','text'=>'ساعات العمل الى ','placeholder'=>'اختر ساعة نهاية العمل'])
                                            @endcomponent

                                        </div>

                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 col-xs-6" style="margin-top: 10px;margin-bottom: 30px;">
                                            <button type="submit"
                                                    class="btn btn-block m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                                <i class="fa fa-check"></i>
                                                <span>تعديل</span>
                                            </button>
                                        </div>
                                    </div>


                                    <div class="clearfix"></div>
                                </form>
                                <br>
                                <form action="{{route('system.daysandtimes.saveDaysRes')}}" method="post" id="form">
                                    @csrf

                                    <div class="col-md-12">
                                        <h3 style="text-align: center">عدد ايام الحجز</h3>
                                        <small style="text-align: center;display: block;color: grey">الرجاء ادخال عدد ايام العمل
                                            لتتمكن من تحديد الايام المتاحة والغير متاحة
                                        </small>
                                    </div>
                                    <div class="row justify-content-center">


                                        <div class="col-md-6">
                                            @component('components.input',['data'=>$days_count,'name'=>'days_count','text'=>'المدة الاكبر لاستقبال الطلبات'])
                                            @endcomponent

                                        </div>

                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 col-xs-6" style="margin-top: 10px;margin-bottom: 30px;">
                                            <button type="submit"
                                                    class="btn btn-block m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">
                                                <i class="fa fa-check"></i>
                                                <span>تعديل</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                        <hr>


                        <div class="row">
                            <div class="col-md-12">
                                <h3 style="text-align: center">الايام الخاصة</h3>
                                <small style="text-align: center;display: block;color: grey">اختر الايام الغير متاح
                                    فيها
                                </small>
                                <small style="text-align: center;display: block;color: grey">سيتم تقسيم الايام الى
                                    مجموعات من 30 يوم
                                </small>
                            </div>

                            <div class="col-md-12">

                                <ul class="nav nav-tabs nav-justified">
                                    <?php
                                    \Carbon\Carbon::setLocale('ar');
                                    $months = array('يناير', 'فبراير', 'مارس', 'ابريل', 'مايو', 'يونيو', 'يوليو', 'اغسطس',
                                        'سبتمبر', 'اكتوبر', 'نوفمبر', 'ديسمبر');

                                    $now = \Carbon\Carbon::now(); $count = ceil($days_count / 30); for($j = 0;$j < $count;$j++){
                                    if ((($j + 1) * 30) < $days_count) {
                                        $to = 29;

                                    } else {
                                        $to = $days_count - ($j * 30) - 1;

                                    }
                                    ?>
                                    <li  class="nav-item" >
                                        <a class="nav-link {{$j == 0?'active':''}}" data-toggle="tab"  href="#tab{{$j}}">
                                            <span>من :  </span>
                                            <span>{{$now->day}} {{$months[$now->month-1]}}</span>
                                            <span> , الى : </span>
                                            <span><?php $now->addDays($to) ?>{{$now->day}} {{$months[$now->month-1]}}</span>
                                        </a>
                                    </li>
                                    <?php $now->addDay(); }?>
                                </ul>


                                <div class="tab-content">
                                    <?php $now = \Carbon\Carbon::now()->subDay(); $count = ceil($days_count / 30); for($j = 0;$j < $count;$j++){ ?>
                                    <div id="tab{{$j}}" class="tab-pane container  {{$j == 0?'active':'fade'}}">


                                        <?php
                                        if ((($j + 1) * 30) < $days_count) {
                                            $to = 30;

                                        } else {
                                            $to = $days_count - ($j * 30);

                                        }
                                        for($i = 0;$i < $to;$i++){
                                        $now->addDay();
                                        $isDayOn=\App\Models\Day::find($now->dayOfWeek+1);
                                        $isDayOut=\App\Models\OutDate::where('date',$now->toDateString())->first();
                                        $free=true;
                                        if($isDayOn->used == 0){
                                            $free=0;
                                        }
                                        if($isDayOut){
                                            if($isDayOut->is_out){
                                                $free=0;
                                            }
                                            if($isDayOut->is_out == 0){
                                                $free=1;
                                            }
                                        }


                                        ?>
                                        <div class="dateSel {{$free?'mygreen':'myred'}}">
                                                       <span class="sts {{$free?'free':'used'}}">
                                           @if($free)متاح@else @if($isDayOn->used == 0) عطلة @else محجوز @endif @endif
                                           </span>
                                            <h3>{{$now->format('m-d')}}</h3>
                                            <span class="day-name">{{$isDayOn->name_ar}}</span>

                                            <button class="btn  changeDateStatus" data-date="{{$now->toDateString()}}">
                                                <i class="fa  {{$free?'fa-check':''}}"></i></button>

                                        </div>


                                        <?php }?>

                                    </div>

                                    <?php }?>

                                </div>


                            </div>
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


        })

    </script>

    <script>
        $(function () {
            $("body").on('click', '.changeDateStatus',
                function () {
                    var thisF = $(this);

                    var date = $(this).data('date');
                    var dev = thisF.parent();
                    var text = "متاح";
                    if (dev.hasClass('mygreen')) {
                        text = "مشغول";
                    }

                    swal(
                        {
                            title:"هل انت متأكد ؟",
                            text:"هل تريد بالتأكيد تغيير حالة التاريخ " + date + " الى " + text,
                            type:"warning",
                            showCancelButton:1,
                            confirmButtonText:"نعم , قم بالاجراء !",
                            cancelButtonText:"لا, الغي العملية !",
                            reverseButtons:1
                        }).then(function(e){

                        if(e.value){

                            var url = '{{route('system.daysandtimes.changeDate')}}';
                            var token = '{{csrf_token()}}';
                            $.post(url,
                                {
                                    _token: token,
                                    date: date,
                                },
                                function (data, status) {
                                    if (data.done == 1) {
                                        swal({
                                            title: 'تم تغيير الحالة بنجاح',
                                            text: 'تم تغيير الحالة بنجاح',
                                            type: 'success',
                                            timer: 2000,
                                            showConfirmButton: false
                                        }).then(
                                            function () {

                                                var dev = thisF.parent();
                                                if (dev.hasClass('mygreen')) {
                                                    dev.removeClass('mygreen').addClass('myred');
                                                    dev.find('.sts').removeClass('free').addClass('used').text('محجوز');
                                                    thisF.html('<i class="fa"></i>');

                                                } else {
                                                    dev.removeClass('myred').addClass('mygreen');
                                                    dev.find('.sts').removeClass('used').addClass('free').text('متاح');
                                                    thisF.html('<i class="fa fa-check"></i>');


                                                }
                                            }
                                        )
                                    } else {

                                        swal({
                                            title: 'حدث خطأ ما',
                                            text: 'خطأ مجهول',
                                            type: 'error',
                                            timer: 4000,
                                            showConfirmButton: false
                                        })

                                    }
                                });

                        }else{
                            e.dismiss&&swal("تم الالغاء","لم يتم عمل اي تغيير","error");

                        }
                    });


                })
        })
    </script>

@endsection
