
@extends('website._layout')

@section('title', 'الرئيسية')

@section('page_content')


  <!-- Start Hero Section -->
<section id="home" class="hero">
    <?php
               $android = \App\Models\Settings::where('name','android')->first();
               $ios = \App\Models\Settings::where('name','ios')->first();

?>
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="hero-text">
                    <h1>
                        تطبيق نوادر القصيم
                    </h1>
                    <p>
                    اطلب خروفك حي او مذبوح باوزان مختلفة وكميات متعدده  
                    </p>
                    <div class="btn-wrapper">
                        <a href="{{$android->value??''}}">
                            <img src="{{asset('/website1/')}}/resources/theme/img/g-play.png" alt="">
                        </a>
                        <a href="{{$ios->value??''}}">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-store.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="image-wrapper">
                    <span class="hero-icon-1">
                        <img src="{{asset('/website1/')}}/resources/theme/img/hero-icon-1.png" alt="">
                    </span>
                    <span class="mobile">
                        <img src="{{asset('/website1/')}}/resources/theme/img/hero-mobile-app.png" alt="">
                    </span>
                    <span class="hero-icon-2">
                        <img src="{{asset('/website1/')}}/resources/theme/img/hero-icon-2.png" alt="">
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Hero Section -->

<!-- Start Features Section -->
<section id="features" class="features">
    <div class="container">
        <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="image-wrapper">
                    <span class="mobile">
                        <img src="{{asset('/website1/')}}/resources/theme/img/features-mobile-app.png" alt="">
                    </span>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="features-text">
                    <div class="title">
                        <h3>
                            مميزات التطبيق
                        </h3>
                    </div>
                    <ul>
                        <li>
                            <div class="icon">
                                <img src="{{asset('/website1/')}}/resources/theme/img/features-icon-1.png" alt="">
                            </div>
                            <div class="text">
                                <h5>
                                    انواع متعددة
                                </h5>
                                <p>
                                اضافة انواع متعددة لسلة المشتريات اضافة انواع من الحلال لصفحة المفضلة لتسهيل عملية الرجوع اليها وقت الحاجة البحث عن الانواع المختلفة بسهولة تامة
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="{{asset('/website1/')}}/resources/theme/img/features-icon-2.png" alt="">
                            </div>
                            <div class="text">
                                <h5>
                                خدمة توصيل
                                </h5>
                                <p>
                                اضافة عنوان المستخدم لايصال الحلال الحي والمذبوح بوقت قياسي عرض قائمة بجميع الطلبات اللتي تمت من خلال التطبيق اشعارات في حال وجود اي جديد داخل التطبيق
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="icon">
                                <img src="{{asset('/website1/')}}/resources/theme/img/features-icon-3.png" alt="">
                            </div>
                            <div class="text">
                                <h5>
                                طرق دفع مختلفة
                                </h5>
                                <p>
                                يمكنك الاشتراك في التطبيق لشراء خروف حي أو مذبوح بعدة طرق دفع من انواع الحلال الموجودة مع امكانيه توفير مجموعة من الخيارات مثل طلب الخروف حي او مذبوح بأوزان متعددة وكميات مفتوحة
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Features Section -->
<?php
               $andriod = \App\Models\Settings::where('name','android')->first();
               $ios = \App\Models\Settings::where('name','ios')->first();

?>
<!-- Start Download App Section -->
<section id="download-app" class="download-app">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="text">
                    <h2>
                        حمل التطبيق الآن
                    </h2>
                    <p>
                    التطبيق متاح علي منصات ايفون واندرويد
                    </p>
                    <div class="btn-wrapper">
                        <a href="{{$andriod->value}}">
                            <img src="{{asset('/website1/')}}/resources/theme/img/g-play-w.png" alt="">
                        </a>
                        <a href="{{$ios->value}}">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-store-w.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Download App Section -->

<!-- Start App Slider Section -->
<section id="app-photo" class="app-slider">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="title">
                    <h3>
                        صور التطبيق
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/0.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/1.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/2.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/3.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/4.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/5.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/6.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/7.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/8.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/9.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/10.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/11.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/12.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/13.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/14.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="item">
                            <img src="{{asset('/website1/')}}/resources/theme/img/app-design/15.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End App Slider Section -->

<!-- Start Contact Section -->
<section id="contact" class="contact">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="title">
                    <h3>
                        تواصل معنا
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-12 col-sm-12">
                <div class="logo">
                    <img src="{{asset('/website1/')}}/resources/theme/img/footer-logo.png" alt="">
                </div>
                <h5>
                    للتواصل المباشر
                </h5>
                <ul class="contact-list">
                    <li>
                        <span>
                            <img src="{{asset('/website1/')}}/resources/theme/img/phone-icon.png" alt="">
                        </span>
                        <span>
                        00966552545888
                        </span>
                    </li>
                    <li>
                        <span>
                            <img src="{{asset('/website1/')}}/resources/theme/img/email-icon.png" alt="">
                        </span>
                        <span>
                        info@nwader.com.sa
                        </span>
                    </li>
                </ul>
                <ul class="social">
                    <li>
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M22.162 5.656a8.384 8.384 0 0 1-2.402.658A4.196 4.196 0 0 0 21.6 4c-.82.488-1.719.83-2.656 1.015a4.182 4.182 0 0 0-7.126 3.814 11.874 11.874 0 0 1-8.62-4.37 4.168 4.168 0 0 0-.566 2.103c0 1.45.738 2.731 1.86 3.481a4.168 4.168 0 0 1-1.894-.523v.052a4.185 4.185 0 0 0 3.355 4.101 4.21 4.21 0 0 1-1.89.072A4.185 4.185 0 0 0 7.97 16.65a8.394 8.394 0 0 1-6.191 1.732 11.83 11.83 0 0 0 6.41 1.88c7.693 0 11.9-6.373 11.9-11.9 0-.18-.005-.362-.013-.54a8.496 8.496 0 0 0 2.087-2.165z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 0 1 1.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.218 1.79-.465 2.428a4.883 4.883 0 0 1-1.153 1.772 4.915 4.915 0 0 1-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.218-2.428-.465a4.89 4.89 0 0 1-1.772-1.153 4.904 4.904 0 0 1-1.153-1.772c-.248-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.066.217-1.79.465-2.428a4.88 4.88 0 0 1 1.153-1.772A4.897 4.897 0 0 1 5.45 2.525c.638-.248 1.362-.415 2.428-.465C8.944 2.013 9.283 2 12 2zm0 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6.5-.25a1.25 1.25 0 0 0-2.5 0 1.25 1.25 0 0 0 2.5 0zM12 9a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"/><path d="M11.871 21.764c-1.19 0-1.984-.561-2.693-1.056-.503-.357-.976-.696-1.533-.79a4.568 4.568 0 0 0-.803-.066c-.472 0-.847.071-1.114.125-.17.03-.312.058-.424.058-.116 0-.263-.032-.32-.228-.05-.16-.081-.312-.112-.459-.08-.37-.147-.597-.286-.62-1.489-.227-2.38-.57-2.554-.976-.014-.044-.031-.09-.031-.125-.01-.125.08-.227.205-.25 1.181-.196 2.242-.824 3.138-1.858.696-.803 1.035-1.579 1.066-1.663 0-.01.009-.01.009-.01.17-.351.205-.65.102-.895-.191-.46-.825-.656-1.257-.79-.111-.03-.205-.066-.285-.093-.37-.147-.986-.46-.905-.892.058-.312.472-.535.811-.535.094 0 .174.014.24.05.38.173.723.262 1.017.262.366 0 .54-.138.584-.182a24.93 24.93 0 0 0-.035-.593c-.09-1.365-.192-3.059.24-4.03 1.298-2.907 4.053-3.14 4.869-3.14L12.156 3h.05c.815 0 3.57.227 4.868 3.139.437.971.33 2.67.24 4.03l-.008.067c-.01.182-.023.356-.032.535.045.035.205.169.535.173.286-.008.598-.102.954-.263a.804.804 0 0 1 .312-.066c.125 0 .25.03.357.066h.009c.299.112.495.321.495.54.009.205-.152.517-.914.825-.08.03-.174.067-.285.093-.424.13-1.057.335-1.258.79-.111.24-.066.548.103.895 0 .01.009.01.009.01.049.124 1.337 3.049 4.204 3.526a.246.246 0 0 1 .205.25c0 .044-.009.089-.031.129-.174.41-1.057.744-2.555.976-.138.022-.205.25-.285.62a6.831 6.831 0 0 1-.112.459c-.044.147-.138.227-.298.227h-.023c-.102 0-.24-.013-.423-.049a5.285 5.285 0 0 0-1.115-.116c-.263 0-.535.023-.802.067-.553.09-1.03.433-1.534.79-.717.49-1.515 1.051-2.697 1.051h-.254z"/></svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-12 col-sm-12">
                <form dir="rtl" method="post" action="{{route('website.do.contact')}}"  >                    <div class="row">
                        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label>الاسم</label>
                            <input type="text" name="name"  value="{{old('name')}}" class="form-control">
                            @show_error('name')
                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label>البريد الالكتروني</label>
                            <input type="email"  value="{{old('email')}}"  class="form-control">
                            @show_error('email')

                        </div>
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <label>الرسالة</label>
                            <textarea class="form-control" required name="details"  id="" cols="30" rows="10">{{old('details')}}</textarea>
                            @show_error('details')

                        </div>
                        <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-3">
                            <button class="btn btn-orange">
                                ارسال
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Section -->


@endsection

