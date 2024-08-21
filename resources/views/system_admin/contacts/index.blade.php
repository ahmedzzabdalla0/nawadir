@extends('layouts.admin')
@php
    $Disname='اتصل بنا';
    $icon='fa fa-comment';

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

                                <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">
                                    <a href="#" class="m-portlet__nav-link m-dropdown__toggle btn m-btn--pill m-btn--air btn-outline-warning m-btn m-btn--custom">
                                        <i class="fa fa-cog"></i>
                                        <span>العمليات</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav">
                                                        @cando('delete','contacts')
                                                        <li class="m-nav__item">
                                                            <a href="javascript:;" class="m-nav__link DoAction"
                                                               data-url="{{route('system.contacts.delete')}}"
                                                               data-token="<?= csrf_token() ?>">
                                                                <i class="m-nav__link-icon flaticon-delete "></i>
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
                    <div class="m-portlet__body">

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
                                        <th class="text-center">البريد الالكتروني</th>
                                        <th class="text-center">النص</th>
                                        <th class="text-center">تاريخ الارسال</th>
                                        <th class="text-center">الإعدادات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($out as $o)
                                        <tr id="TR_{{$o->id}}">

                                            <td class="LOOPIDS">{{$loop->iteration}}</td>
                                            <td style="text-align: center;vertical-align: middle;">
                                                    <label class="m-checkbox m-checkbox--solid m-checkbox--success m-size-table">
                                                        <input type="checkbox" value="<?= $o->id ?>" name="Item[]" class="CheckedItem" id="che_{{$o->id}}">
                                                        <span></span>
                                                    </label>
                                            </td>
                                            <td class="text-center"  id="email_<?=$o->id?>"><?=$o->email?></td>
                                            <td  class="text-center"><?=$o->details?></td>
                                            <td class="text-center"><?=$o->created_at->toDateString()?></td>
                                            <td class="text-center">

                                                    <ul class="list-inline">

                                                        <li>
                                                            <button type="button"
                                                               class="btn m-btn--pill btn-sm m-btn--air btn-outline-info m-btn m-btn--custom  showit"
                                                               data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="اضغط لعرض التفاصيل"
                                                               data-body="<?=$o->details?>"
                                                               data-id="<?= $o->id?>"
                                                               data-toggle="modal" data-target="#show"

                                                            >
                                                                <i class="fa fa-laptop"></i> التفاصيل </button>
                                                        </li>

                                                        @cando('delete','contacts')
                                                        <li>
                                                            <button type="button"
                                                                    data-id="<?= $o->id ?>"
                                                                    data-url="{{route('system.contacts.delete')}}"
                                                                    data-token="{{csrf_token()}}"
                                                                    data-skin="dark" data-tooltip="m-tooltip" data-placement="top" title="حذف"
                                                                    class="btn m-btn--pill btn-sm m-btn--air btn-outline-danger m-btn m-btn--custom btn-del">
                                                                <i class="fa fa-trash "></i>
                                                                حذف
                                                            </button>


                                                        </li>
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
                            <div class="note note-info">
                                <h4 class="block">لا يوجد بيانات للعرض</h4>
                            </div>
                        @endif

                    </div>
                </div>


            </div>
        </div>
    </div>
    <div id="show" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" >

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">تفاصيل الرسال</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('system.contacts.replay')}}" id="form" method="post">
                <div class="modal-body">
                    <h4>الايميل : <span id="email">Email</span></h4>
                    <h4>التفاصيل : </h4>
                    <p id="body" style="width: 100%;word-wrap: break-word;"></p>

                    <h4 class="modal-title">ارسال رد</h4>


                        <?=csrf_field()?>
                        <input type="hidden" name="email" id="email2">
                        <input type="hidden" name="id" id="id">

                        <div class="form-group">
                            <textarea name="mess" required id="mess"rows="3" class="form-control m-input m-input--pill m-input--air"></textarea>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn m-btn--pill m-btn--air btn-outline-metal m-btn m-btn--custom" data-dismiss="modal">اغلاق</button>
                    <button type="submit" class="btn m-btn--pill m-btn--air btn-outline-primary m-btn m-btn--custom">ارسال رد</button>
                </div>
                </form>
            </div>

        </div>
    </div>
@endsection

@section('custom_scripts')
    <script>
        $(function () {

            $(".showit").click(function () {

               var n= $('#body').text($(this).data('body'));

                $('#email').text($('#email_'+$(this).data('id')).text());
                $('#email2').val($('#email_'+$(this).data('id')).text());
                $('#id').val($(this).data('id'));
            });
            $(".replay").click(function () {
                $('#email').val($(this).data('email'));
            });

        })
    </script>
@endsection