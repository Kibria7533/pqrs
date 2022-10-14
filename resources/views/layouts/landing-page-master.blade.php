@php
    Session::forget('locale');
    Session::put('locale', 'bn');
@endphp

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
    <style>
        @import url('https://fonts.maateen.me/bangla/font.css');

        * {
            box-sizing: border-box;
            margin: 0;
        }

        body {
            font-family: 'Bangla', Arial, sans-serif !important;
            background: url('{{ asset('images/landing-bg.svg') }}') no-repeat center center;
            background-size: cover;
        }

        .site-footer {
            min-height: 147px;
            background: #FFFFFF;
            box-shadow: 4.45707px 4.45707px 15px rgba(221, 221, 221, 0.5);
            align-items: center;
            justify-content: center;
            padding-top: 2%;
        }

        .footer-item {
            font-size: 14px;
            font-weight: bold;
            line-height: 23px;
            color: #434343;
        }

        .footer-item:first-child {
            margin-left: 3%;
        }

        .footer-item:nth-last-child(1) {
            margin-left: 8%;
        }

        .footer-item-heading, .footer-item-content {
            padding: 8px;
        }

        .footer-item-content a {
            text-decoration: none;
            color: #92278F;
        }

        .menu-active a {
            color: #28a745 !important;
        }

        .nav-item:hover a {
            color: #28a745 !important;
        }

        .custom-header-bg {
            background: #7200CA;
            color: white;
        }

        .custom-form-control {
            background: #FBFDFF;
            border: 1px solid #E1E2E3;
            box-sizing: border-box;
            border-radius: 5px;
            height: 45px;
        }

        span.select2-selection.select2-selection--single {
            background: #FBFDFF;
            border: 1px solid #E1E2E3;
            box-sizing: border-box;
            border-radius: 5px;
            height: 45px !important;
        }

        .flat-date {
            background: #fbfdff !important;
        }

        .left-border-radius-rounded {
            border-radius: 4px 0 0 4px !important;
        }


    </style>


    @stack('css')
</head>
<body class="skin-blue sidebar-collapse">

@yield('header', \Illuminate\Support\Facades\View::make('master::layouts.partials.front-end.header'))
@yield('content')

@yield('footer', \Illuminate\Support\Facades\View::make('master::layouts.partials.front-end.footer'))


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
