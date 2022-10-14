<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <title>@yield('title', 'LRMS - Noakhali')</title>

    <!-- Bootstrap v4 with admin-lte v3 -->
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/css/landing-page.css')}}">
    @stack('css')
</head>
<body class="hold-transition skin-blue sidebar-collapse">
{{--<div class="container">--}}
    <div class="navtop-container">
        <div class="wrapper">
            <nav>
                <div class="navtop-container-left">
                    <p>ভূমি মন্ত্রণালয়, গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
                    <input id="global-search" type="text" placeholder="খুজুঁন">
                </div>
                <p>১০ ফাল্গুন ১৪২৭ / ২৫ মার্চ ২০২২, শুক্রবার</p>
            </nav>
        </div>
    </div>

    <div class="navbottom-container">
        <div class="wrapper">
            <nav>
                <div class="logo">
                    <img class="logo-img" src="images/logo.svg" alt="">
                    <!--<h1>Khas Jomi Bebosthapona</h1>
                    <p>গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>-->
                </div>

                <ul class="nav-menus">
                    <li class="menu-item">
                        <a href="#"> হোম </a>
                    </li>
                    <li class="menu-item">
                        <a href="#"> মন্ত্রণালয়/বিভাগ/সংস্থা  </a>
                    </li>
                    <li class="menu-item">
                        <a href="#"> ভূমি সেবা </a>
                    </li>
                    <li class="menu-item">
                        <a href="#"> অভিযোগ/ পরামর্শ </a>
                    </li>
                    <li class="menu-item">
                        <a href="#"> যোগাযোগ </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="header-container">
        <div class="wrapper">
            <div class="slider-main"></div>
            <div class="marquee-text">
                <div class="marquee-text-content">
                    <span class="marquee-text-content-header">বিস্তারিত:</span> <marquee direction="left">নামজারি খতিয়ান ব্যতিত সকল জেলায় সব ধরনের খতিয়ান অনলাইনের মাধ্যমে আবেদন ও সরবরাহ করা হয়।</marquee>
                </div>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="wrapper">
            <div class="section-left">
                <div class="application-buttons">
                    <div class="apply-link">
                        <img class="apply-link-icon" src="images/apply-icon.svg" alt="">
                        <h3 class="apply-link-text">আবেদন করুন</h3>
                    </div>
                    <div class="application-track">
                        <img class="application-track-icon" src="images/application-track-icon.svg" alt="">
                        <h3 class="application-track-text">আবেদন ট্র্যাকিং</h3>
                    </div>
                </div>

                <div class="dynamic-content">
                    <legend class="khas-jomi-search-heading">খাস জমি অনুসন্ধান</legend>
                    <form class="khas-jomi-search p-4">
                        <div class="row mb-4">
                            <div class="form-group col-sm-6">
                                <label for="upazila"> উপজেলা </label>
                                <select id="upazila" class="form-control">
                                    <option value=""> নির্বাচন করুন </option>
                                    <option value="3"> ডেমরা </option>
                                    <option value="4"> উত্তরা </option>
                                    <option value="5"> খিলগাঁও </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="mouja"> মৌজা </label>
                                <select id="mouja" class="form-control">
                                    <option value=""> নির্বাচন করুন </option>
                                    <option value="3"> ডেমরা </option>
                                    <option value="4"> উত্তরা </option>
                                    <option value="5"> খিলগাঁও </option>
                                </select>
                            </div>
                        </div>
                        <fieldset class="row mb-4 ms-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                                <label class="form-check-label" for="gridRadios1">
                                    খতিয়ান নং
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                <label class="form-check-label" for="gridRadios2">
                                    দাগ নং
                                </label>
                            </div>
                        </fieldset>
                        <div class="form-group col-sm-6 mb-4">
                            <input type="text" id="khotian-no" class="form-control" placeholder="খতিয়ান নং">
                        </div>
                        <div class="form-group col-sm-6 mb-4">
                            <label for="captcha"> ক্যাপচা কোড </label>
                            <div class="input-group">
                                <div class="input-group-text">২৬৭৩</div>
                                <input type="text" class="form-control" id="captcha">
                            </div>
                        </div>
                        <button type="submit" class="search-khotian-btn btn btn-success mb-3">অনুসন্ধান করুন</button>
                    </form>
                </div>
            </div>
            <div class="section-right">
                <ul class="section-right-buttons">
                    <li class="section-right-button-items">
                        <img src="images/nagorik-corner.svg" alt="">
                        <a href="#"> User Login </a>
                    </li>
                    <li class="section-right-button-items" id="office-login-btn">
                        <img src="images/office-login.svg" alt="">
                        <a href="#"> Office  Login </a>
                    </li>
                    <li class="section-right-button-items" id="hotline-btn">
                        <img src="images/hotline.svg" alt="">
                        <a href="#">(+88 09613 570 632) Hotline Number</a>
                    </li>
                </ul>

                <div class="map-content mb-3">
                    <p>জেলা ম্যাপ</p>
                    <div class="map-image">
                        <img src="images/map.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Khaas Jomir poriman Cards -->
    <div class="khas-jomi-info-cards">
        <div class="wrapper">
            <div class="khas-jomi-info-heading text-center mt-4">
                <legend>খাস জমির তথ্য ২০২০</legend>
            </div>
            <div class="row khas-jomi-info-content mb-5">
                <div class="col-sm-4 khas-jomi-info-item">
                    <table class="table-bordered">
                        <tr>
                            <th colspan="2" class="p-2 text-center">মোট খাস জমির পরিমাণ (একরে)</th>
                        </tr>
                        <tr>
                            <td class="p-2 text-center">
                                <h1>১০১১.৮১</h1>
                                <p>কৃষি</p>
                            </td>
                            <td class="p-2 text-center">
                                <h1>১০১১.৮১</h1>
                                <p>অকৃষি</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4 khas-jomi-info-item">
                    <table class="table-bordered">
                        <tr>
                            <th colspan="2" class="p-2 text-center">বন্দোবস্তযোগ্য খাস জমির পরিমাণ (একরে)</th>
                        </tr>
                        <tr>
                            <td class="p-2 text-center">
                                <h1>১০১১.৮১</h1>
                                <p>কৃষি</p>
                            </td>
                            <td class="p-2 text-center">
                                <h1>১০১১.৮১</h1>
                                <p>অকৃষি</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4 khas-jomi-info-item">
                    <table class="table-bordered">
                        <tr>
                            <th colspan="2" class="p-2 text-center">বন্দোবস্ত প্রাপ্ত ভূমিহীন পরিবারের সংখ্যা</th>
                        </tr>
                        <tr>
                            <td class="p-2 text-center">
                                <p>&nbsp;</p>
                                <h1>৩৯৪৩</h1>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-4 khas-jomi-info-item">
                    <table class="table-bordered">
                        <tr>
                            <th colspan="2" class="p-2 text-center"> বন্দোবস্ত প্রদানকৃত খাস জমির পরিমাণ (একরে)</th>
                        </tr>
                        <tr>
                            <td class="p-2 text-center">
                                <p>&nbsp;</p>
                                <h1>১০১১.৮১</h1>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="site-footer">
        <div class="wrapper">
            <div class="row">
                <div class="col-sm footer-item">
                    <div class="footer-item-heading">
                        <p> গুরুত্বপূর্ণ লিঙ্ক  </p>
                    </div>
                    <div class="footer-item-content">
                        <a href="bangladesh.gov.bd">bangladesh.gov.bd</a><br>
                        <a href="noakhali.gov.bd">noakhali.gov.bd</a>
                    </div>
                </div>
                <div class="col-sm footer-item">
                    <div class="footer-item-heading">
                        <p> সামাজিক যোগাযোগ </p>
                    </div>
                    <div class="footer-item-content">
                        <a href="#"><img src="images/facebook-logo.svg" alt=""></a>
                        <a href="#"><img src="images/youtube-logo.svg" alt=""></a>
                    </div>
                </div>
                <div class="col-sm footer-item">
                    <div class="footer-item-heading">
                        <p> পরিকল্পনা ও বাস্তবায়নে </p>
                    </div>
                    <div class="footer-item-content">
                        <a href="#"><img src="images/ministry-icon.svg" alt=""></a>
                    </div>
                </div>
                <div class="col-sm footer-item">
                    <div class="footer-item-heading">
                        <p> কারিগরি সহায়তায় </p>
                    </div>
                    <div class="footer-item-content">
                        <a href="#"><img src="images/softbd-logo.svg" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--</div>--}}
<script src="{{asset('/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>
<script src="{{asset('/js/admin-lte.js')}}"></script>
<script src="{{asset('/js/on-demand.js')}}"></script>
<script>
    @if(\Illuminate\Support\Facades\Session::has('alerts'))
    let alerts = {!! json_encode(\Illuminate\Support\Facades\Session::get('alerts')) !!};
    helpers.displayAlerts(alerts, toastr);
    @endif

    @if(\Illuminate\Support\Facades\Session::has('message'))
    let alertType = {!! json_encode(\Illuminate\Support\Facades\Session::get('alert-type', 'info')) !!};
    let alertMessage = {!! json_encode(\Illuminate\Support\Facades\Session::get('message')) !!};
    let alerter = toastr[alertType];
    alerter ? alerter(alertMessage) : toastr.error("toastr alert-type " + alertType + " is unknown");
    @endif
</script>
@stack('js')
</body>
</html>
