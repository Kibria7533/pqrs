<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <title>@yield('title', 'LRMS')</title>
    <link rel="stylesheet" href="{{asset('/css/app.css')}}">
    <link rel="stylesheet" href="{{asset('/css/frontendStyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/css/OverlayScrollbars.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@300;400;500;700&display=swap"
          rel="stylesheet">


    <style>
        @import url('https://fonts.maateen.me/adorsho-lipi/font.css');
        body {
            /*font-family: 'Nikosh', Arial, sans-serif !important;*/
            font-family: 'AdorshoLipi', Arial, sans-serif !important;
        }

        .custom-header-bg {
            background: #7200CA;
            color:wheat;
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

        /*tinymce unnecessary content hide*/
        #gtx-trans {
            display: none;
        }
    </style>
    @stack('css')
    <script>
        window.select_option_placeholder = '{{__('generic.add_button_label')}}';
    </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @yield('header', \Illuminate\Support\Facades\View::make('master::layouts.partials.master.header'))

    @yield('sidebar', Illuminate\Support\Facades\View::make('master::layouts.partials.master.sidebar'))

    <div class="content-wrapper px-1 py-2">
        @yield('content')

        <div id="loading-sniper"
             style="z-index: 99999; position: fixed; height: 100vh;width: 100%;top: 0px; left: 0; right: 0; bottom: 0px; background: rgba(0,0,0,.4); display: none; overflow: hidden;">
            <div class="holder" style="width: 200px;height: 200px;position: relative; margin: 10% auto;">
                <img src="/images/loading.gif" style="width: 75px;margin: 34%;">
            </div>
        </div>
    </div>

    @yield('footer', Illuminate\Support\Facades\View::make('master::layouts.partials.master.footer'))
</div>
<script src="{{asset('/js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.0/js/OverlayScrollbars.min.js"></script>
<script src="{{asset('/js/admin-lte.js')}}"></script>
<script src="{{asset('/js/on-demand.js')}}"></script>

<script src="{{asset('/js/datatable/jquery.dataTables.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{asset('/js/en2bn/en2bn.js')}}"></script>

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
<script>
</script>
</html>

