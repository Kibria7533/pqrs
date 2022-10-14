@extends('master::layouts.landing-page-master')

@section('title')
    Home
@endsection


@section('content')
    <div class="container" id="main-container">
        <div class="main-content-area p-3"
             style="margin-bottom: 150px; background: #ffffff; box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2 class="">{{ __('My Profile') }}</h2>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Name') }}</p>
                                            <div class="input-box">
                                                {{Auth::guard('landless')->user()->name}}
                                            </div>
                                        </div>

                                        <div class="col-md-6 custom-view-box">
                                            <p class="label-text">{{ __('Email') }}</p>
                                            <div class="input-box">
                                                {{Auth::guard('landless')->user()->email}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-1"></div>

                <div class="col-md-3 ">

                    @include('master::landless-portal.utils.sidebar')

                </div>

{{--                <div class="col-md-12">--}}
{{--                    <div class="p-4">--}}
{{--                        <h3 class="text-center">খাস জমির তথ্য ২০২০</h3>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-3 p-1">--}}
{{--                                <table class="table-bordered w-100">--}}
{{--                                    <tr>--}}
{{--                                        <th colspan="2" class="p-2 text-center">মোট খাস জমির পরিমাণ (একরে)</th>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td class="p-2 text-center">--}}
{{--                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>--}}
{{--                                            <p>কৃষি</p>--}}
{{--                                        </td>--}}
{{--                                        <td class="p-2 text-center">--}}
{{--                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>--}}
{{--                                            <p>অকৃষি</p>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3 p-1">--}}
{{--                                <table class="table-bordered w-100">--}}
{{--                                    <tr>--}}
{{--                                        <th colspan="2" class="p-2 text-center">বন্দোবস্তযোগ্য খাস জমির পরিমাণ (একরে)--}}
{{--                                        </th>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td class="p-2 text-center">--}}
{{--                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>--}}
{{--                                            <p>কৃষি</p>--}}
{{--                                        </td>--}}
{{--                                        <td class="p-2 text-center">--}}
{{--                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>--}}
{{--                                            <p>অকৃষি</p>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3 p-1">--}}
{{--                                <table class="table-bordered w-100">--}}
{{--                                    <tr>--}}
{{--                                        <th colspan="2" class="p-2 text-center">বন্দোবস্ত প্রাপ্ত ভূমিহীন পরিবারের--}}
{{--                                            সংখ্যা--}}
{{--                                        </th>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td class="p-2 text-center">--}}
{{--                                            <b class="text-success"--}}
{{--                                               style="font-size: 20px;display: block;padding: 20px;}">--}}
{{--                                                ৩৯৪৩--}}
{{--                                            </b>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-3 p-1">--}}
{{--                                <table class="table-bordered w-100">--}}
{{--                                    <tr>--}}
{{--                                        <th colspan="2" class="p-2 text-center"> বন্দোবস্ত প্রদানকৃত খাস জমির পরিমাণ--}}
{{--                                            (একরে)--}}
{{--                                        </th>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td class="p-2 text-center">--}}
{{--                                            <b class="text-success"--}}
{{--                                               style="font-size: 20px;display: block;padding: 20px;}">--}}
{{--                                                ১০১১.৮১--}}
{{--                                            </b>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        @media screen and (max-width: 680px) {
            /*.carousel-item{
                height: 30px!important;
            }*/
            .application-icon {
                height: 50px !important;
                width: 50px !important;
            }

            .application-label {
                padding: 0 !important;
                margin-top: -10px;
            }

            .site-footer {
                text-align: center;
            }
        }


    </style>
@endpush

