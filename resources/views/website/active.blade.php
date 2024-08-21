@extends('website._layout')
@section('title', 'تفعيل الحساب')
@section('page_content')
    <section class="breadcrumbs_search">
        <div class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div class="breadcrumbs_container clearfix">
                        <ol class="breadcrumb">
                            <li class="icon"><img src="{{asset('website/images/icons/monitor_ic.png')}}"
                                                  class="img-responsive"></li>
                            <li><a href="{{url('/')}}">الرئيسية</a></li>
                            <li class="active">تفعيل الحساب</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="search_container">
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.breadcrumbs_search -->
    <section class="auth_section">
        <div class="container">
            <div class="auth_content_wrap">
                <div class="tabs_head">
                    <ul class="nav nav-tabs">
                        <li  class="active"  ><a data-toggle="tab" href="#login">تفعيل الحساب</a>
                        </li>
                    </ul>
                </div>
                <div class="tabs_body">
                    <div class="tab-content">
                        <div id="login" class="tab-pane fade  in  active ">
                            <div class="login_form_container">
                                <h3 class="title text-center">أهلا بك</h3>
                                <p class="sub_title text-center">نسعد بوجودك معنا</p>
                                <form action="{{ route('website.do.activate') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <div class="input-icon">
                                            <i class="lnr lnr-user"></i>
                                            <input type="text" class="form-control" value="@old('code')" placeholder="رمز التفعيل" name="code">
                                        </div>
                                        @show_error('code')
                                    </div>

                                    <div class="login_actions clearfix">
                                        <button type="submit" class="btn ms_btn orange_bg msNoRaduis">تفعيل الحساب</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.auth_section -->
@endsection
