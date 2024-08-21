<!-- BEGIN: Left Aside -->
<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn"><i class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " data-menu-vertical="true" m-menu-dropdown="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">

            @cando('view','dashboard')
            <li class="m-menu__item {{!Request::is('*/generalProperties')?HELPER::set_active('system_admin.dashboard'):''}}" aria-haspopup="true">
                <a href="{{route('system_admin.dashboard')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-chart-pie"></i>
                    <span class="m-menu__link-text">لوحة التحكم</span>
                </a>
            </li>
            @endcando
            @cando('view','admins')
            <li class="m-menu__item {{HELPER::set_active('system.admin.index')}}" aria-haspopup="true">
                <a href="{{route('system.admin.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-user-cog"></i>
                    <span class="m-menu__link-text">الادارة</span>
                </a>
            </li>
            @endcando
            @cando('view','settings')
            <li class="m-menu__item {{HELPER::set_active('system.settings.index')}}" aria-haspopup="true">
                <a href="{{route('system.settings.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-cog"></i>
                    <span class="m-menu__link-text">الاعدادات</span>
                </a>
            </li>
            @endcando
            @if(false)
            @cando('view','translations')
            <li class="m-menu__item {{HELPER::set_active('system.translations.index')}}" aria-haspopup="true">
                <a href="{{route('system.translations.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-language"></i>
                    <span class="m-menu__link-text">النصوص</span>
                </a>
            </li>
            @endcando

            @cando('view','areas')
            <li class="m-menu__item {{HELPER::set_active('system.areas.index')}}" aria-haspopup="true">
                <a href="{{route('system.areas.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-globe"></i>
                    <span class="m-menu__link-text">المحافظات والمدن</span>
                </a>
            </li>
            @endcando

@endif
            <li class="m-menu__item {{ Request::is('*/generalProperties')?'m-menu__item--active':'' }} {{HELPER::set_active('system.categories.index')}} {{HELPER::set_active('system.areas.index')}} {{HELPER::set_active('system.sizes.index')}} {{HELPER::set_active('system.cut_types.index')}} {{HELPER::set_active('system_admin.generalProperties')}}" aria-haspopup="true" >
                <a href="{{route('system_admin.generalProperties')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-clipboard-check"></i>
                    <span class="m-menu__link-text">الخصائص العامة</span>
                </a>
            </li>






        @if(false)
            @cando('view','transactions')
            <li class="m-menu__item {{HELPER::set_active('system.transactions.index')}}" aria-haspopup="true">
                <a href="{{route('system.transactions.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-dollar-sign"></i>
                    <span class="m-menu__link-text">الحسابات</span>
                </a>
            </li>
            @endcando
            @endif


            @cando('view','products')
            <li class="m-menu__item {{HELPER::set_active('system.products.index')}}" aria-haspopup="true">
                <a href="{{route('system.products.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-shopping-basket"></i>
                    <span class="m-menu__link-text">المنتجات</span>
                </a>
            </li>
            @endcando

            @cando('view','orders')
            @if(\Auth::guard("system_admin")->user()->hasRole('view','orders'))

                <li class="m-menu__item {{HELPER::set_active('system.orders.index')}} {{HELPER::set_active('system.orders.mainIndex')}} {{HELPER::set_active('system.orders.archive')}} {{HELPER::set_active('system.orders.canceled')}}" aria-haspopup="true">
                    <a href="{{route('system.orders.mainIndex')}}" class="m-menu__link normalLink">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fas fa-shopping-cart"></i>
                        <span class="m-menu__link-text">الطلبات</span>
                    </a>
                </li>
            @endif

            @endcando
            @cando('view','drivers')
            @if(\Auth::guard("system_admin")->user()->hasRole('view','drivers'))

                <li class="m-menu__item {{HELPER::set_active('system.drivers.index')}}" aria-haspopup="true">
                    <a href="{{route('system.drivers.index')}}" class="m-menu__link normalLink">
                        <span class="m-menu__item-here"></span>
                        <i class="m-menu__link-icon fas fa-car"></i>
                        <span class="m-menu__link-text">مندوبين التوصيل</span>
                    </a>
                </li>
            @endif

            @endcando
            @if(false)
            @cando('view','rates')
            <li class="m-menu__item {{HELPER::set_active('system.ratings.index')}}" aria-haspopup="true">
                <a href="{{route('system.ratings.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-comments"></i>
                    <span class="m-menu__link-text">ادارة التقييمات</span>
                </a>
            </li>
            @endcando
            @cando('view','coupons')
            <li class="m-menu__item {{HELPER::set_active('system.coupons.index')}}" aria-haspopup="true">
                <a href="{{route('system.coupons.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-ticket-alt"></i>
                    <span class="m-menu__link-text">كوبونات الخصم</span>
                </a>
            </li>
            @endcando

            @cando('view','balance')
            <li class="m-menu__item {{HELPER::set_active('system.balance.index')}}" aria-haspopup="true">
                <a href="{{route('system.balance.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-wallet"></i>
                    <span class="m-menu__link-text">المحفظة</span>
                </a>
            </li>
            @endcando
@endif
            @cando('view','users')
            <li class="m-menu__item {{HELPER::set_active('system.users.index')}}" aria-haspopup="true">
                <a href="{{route('system.users.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-users"></i>
                    <span class="m-menu__link-text">المستخدمين</span>
                </a>
            </li>
            @endcando
        
            @cando('view','notifications')
            <li class="m-menu__item {{HELPER::set_active('system.notifications.index')}}" aria-haspopup="true">
                <a href="{{route('system.notifications.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-bell"></i>
                    <span class="m-menu__link-text">الاشعارات</span>
                </a>
            </li>
            @endcando
                 @cando('view','ads')
            <li class="m-menu__item {{HELPER::set_active('system.ads.index')}}" aria-haspopup="true">
                <a href="{{route('system.ads.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-file"></i>
                    <span class="m-menu__link-text">الاعلانات</span>
                </a>
            </li>
            @endcando

            @cando('view','contacts')
            <li class="m-menu__item {{HELPER::set_active('system.contacts.index')}}" aria-haspopup="true">
                <a href="{{route('system.contacts.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-comment"></i>
                    <span class="m-menu__link-text">تواصل معنا</span>
                </a>
            </li>
            @endcando

            @cando('view','pages')
            <li class="m-menu__item {{HELPER::set_active('system.pages.index')}}" aria-haspopup="true">
                <a href="{{route('system.pages.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-laptop"></i>
                    <span class="m-menu__link-text">الصفحات</span>
                </a>
            </li>
            @endcando
            @cando('view','reports')
            <li class="m-menu__item {{HELPER::set_active('system.reports.index')}}" aria-haspopup="true">
                <a href="{{route('system.reports.index')}}" class="m-menu__link normalLink">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fas fa-chart-bar"></i>
                    <span class="m-menu__link-text">التقارير</span>
                </a>
            </li>
            @endcando


        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>
