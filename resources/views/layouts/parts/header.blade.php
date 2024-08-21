<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item m-header hide-prnt " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-stack__item--center m-brand__logo hide-prnt">
                        <a href="{{url('/')}}" class="m-brand__logo-wrapper">
                            <img class="header_img" alt="" src="{{asset('admin/imgs/logo_w.png')}}" />
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>

                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width m--margin-right-10-desktop" style="display: none" m-dropdown-toggle="click"
                                m-dropdown-persistent="1">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="NotificationBill">
                                    <span class="m-nav__link-badge m-badge" id="NotificationCount">{{\App\Models\AdminNotification::where('seen',0)->count()}}</span>
                                    <span class="m-nav__link-icon"><i class="flaticon-alert"></i></span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">

                                                    <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                                        <div class="m-list-timeline m-list-timeline--skin-light">
                                                            <div class="m-list-timeline__items" id="NotificationItems">


                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>
                                            <div class="AjaxLoad2">
                                                <div class="m-loader m-loader--brand"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img  src="{{Auth::guard('system_admin')->user()->image_url}}" alt="" />
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center MDD">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic" >
                                                    <img src="{{Auth::guard('system_admin')->user()->image_url}}" alt="" />
                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">{{Auth::guard('system_admin')->user()->name }}</span>
                                                    <span class="m-card-user__email m--font-weight-300 m-link">UserName : {{Auth::guard('system_admin')->user()->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">

                                                    <li class="m-nav__item">
                                                        <a href="{{route('system_admin.logout')}}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder btn-50">
                                                            <i class="flaticon-logout"></i>
                                                            <span>تسجيل الخروج</span>
                                                        </a>
                                                        <a href="{{route('system.admin.profile')}}" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder btn-50">
                                                            <i class="flaticon-profile-1"></i>
                                                            <span>بياناتي</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>

<!-- END: Header -->
