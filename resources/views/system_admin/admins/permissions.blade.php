@extends('layouts.admin')

@php
    $Disname='المدراء';
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
                        <a href="{{route('system.admin.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">{{$Disname}}</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <span class="m-nav__link">
                            <span class="m-nav__link-text">الصلاحيات</span>
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

                        <table class="table">
                            <thead>
                            <tr>
                                <th style="text-align: center">اسم القسم</th>

                                <?php foreach($rules as $r){ ?>
                                <th style="text-align: center"><?=$r->namear?></th>
                                <?php } ?>
                                <th style="text-align: center">فعل</th>
                                <th style="text-align: center">عطل</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($modules as $a){ ?>
                            <tr>
                                <td  style="text-align: center"><?=$a->namear?>
                                </td>

                                <?php foreach($rules as $r){ ?>
                                <td  style="text-align: center">

                                    <?php $name='can'.$r->id; ?>
                                    @if($a->$name)
                                        <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                            <input type="checkbox" class="rule" data-rule="<?=$r->id?>" data-module="<?=$a->id?>"
                                                   @if($adminrule=$user->Rules()->where('rule_id',$r->id)->where('module_id',$a->id)->first())
                                                   checked
                                                   data-ruleid="<?=$adminrule->id ?>"
                                                    @endif
                                            >
                                            <span></span>
                                        </label>
                                    @else
                                        <label class="m-checkbox m-checkbox--danger m-checkbox--disabled m-size-table">
                                            <input type="checkbox">
                                            <span></span>
                                        </label>
                                    @endif
                                </td>
                                <?php } ?>
                                <td style="width: 5%;">
                                    <a href="#" class="reg-all" style="padding: 5px;margin: 0 5px;"
                                       data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="فعل الجميع"><i class="fa fa-check"></i> </a>
                                </td>
                                <td style="width: 5%;">
                                    <a href="#" class="de-reg-all" style="padding: 5px;margin: 0 5px;"
                                       data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="عطل الجميع"><i class="fa fa-times"></i> </a>
                                </td>
                            </tr>

                            <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection

@section('custom_scripts')


    <script>
        $(function () {
            $('.reg-all').click(function (e) {
                e.preventDefault();
                $(this).parent().parent().find('.rule').each(function(i){
                    var IsCheck=$(this).is(":checked");
                    if(! IsCheck) {
                        $(this).click();
                    }
                });
            });
            $('.de-reg-all').click(function (e) {
                e.preventDefault();
                $(this).parent().parent().find('.rule').each(function(i){
                    var IsCheck=$(this).is(":checked");
                    if(IsCheck) {
                        $(this).click();
                    }
                });
            });
            $(".rule").click(function () {
                var User='<?=$user->id?>';
                var Rule=$(this).data('rule');
                var Module=$(this).data('module');
                var IsCheck=$(this).is(":checked");
                var where=$(this);
                if(! IsCheck){
                    var ruleID=$(this).data('ruleid');
                }else{
                    var ruleID=0;

                }
                console.log(IsCheck,ruleID);
                $.post("{{route('system.admin.do.permission')}}",
                    {
                        _token: '<?=csrf_token()?>',
                        User: User,
                        Rule: Rule,
                        Module: Module,
                        IsCheck: IsCheck,
                        ruleID: ruleID,
                    },
                    function (data, status) {
                        if (data.done == 'true') {
                            where.data('ruleid', data.id);
                        } else {
                        }
                    });

            });
        })
    </script>

@endsection


