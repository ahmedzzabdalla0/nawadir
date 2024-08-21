
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nawadir Al-Qasim</title>
    <link rel="stylesheet" href="{{asset('/website1/')}}/resources/bootstrap/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="{{asset('/website1/')}}/resources/vendor/remixicon/remixicon.css">
    <link rel="stylesheet" href="{{asset('/website1/')}}/resources/vendor/aos/aos.css">
    <link rel="stylesheet" href="{{asset('/website1/')}}/resources/vendor/swiper-js/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{asset('/website1/')}}/resources/theme/css/mz-l.css">

</head>
<body>
    
<header class="header fixed-top">
    <nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="{{asset('/website1/')}}/resources/theme/img/logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu" aria-controls="mainMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"/>
                    <path d="M3 4h18v2H3V4zm6 7h12v2H9v-2zm-6 7h18v2H3v-2z"/>
                </svg>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="mainMenu">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#home">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#features">مميزات التطبيق</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#download-app">تحميل التطبيق</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#app-photos">صور التطبيق</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">تواصل معنا </a>
                </li>
            </ul>
        </div>
    </div>
    </nav>
</header>

@yield('page_content')

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="rights">
                    <p>
                    © 2023 جميع الحقوق محفوظة - <a href="#">تطبيق نوادر القصيم</a>
                    </p>
                </div>
            </div>
            <div class="col">
                <div class="powered">
                    <p>
                    التصميم والتطوير - <a href="#" target="blank">ايجاد للحلول الرقمية</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>


<script src="{{asset('/website1/')}}/resources/vendor/other/popper.min.js"></script>
<script src="{{asset('/website1/')}}/resources/bootstrap/bootstrap.min.js"></script>
<script src="{{asset('/website1/')}}/resources/vendor/aos/aos.js"></script>
<script src="{{asset('/website1/')}}/resources/vendor/swiper-js/swiper-bundle.min.js"></script>
<script src="{{asset('/website1/')}}/resources/theme/js/mz-l.js"></script>
</body>
</html>
