<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>

    <title>@yield('title', 'TCM')</title>

    <!-- Bootstrap v4 with admin-lte v3 -->
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;700&display=swap" rel="stylesheet">
    @stack('css')
</head>
<body class="hold-transition skin-blue sidebar-collapse">
<div class="wrapper">
    @yield('header', \Illuminate\Support\Facades\View::make('master::layouts.partials.front-end.header'))
    @yield('full_page_content')

    @sectionMissing('full_page_content')
        <div class="content-wrapper">
            @yield('content')
        </div>
    @endif

    @yield('footer', \Illuminate\Support\Facades\View::make('master::layouts.partials.front-end.footer'))
</div>
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
