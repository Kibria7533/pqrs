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
                                    <h2 class="">{{ __('generic.my_application') }}</h2>
                                </div>
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr class="text-center">
                                                    <th scope="col">{{ __('generic.sl_number') }}</th>
                                                    <th scope="col">{{ __('generic.application_number') }}</th>
                                                    <th scope="col">{{ __('generic.nothi_number') }}</th>
                                                    <th scope="col">{{ __('generic.receipt_number') }}</th>
                                                    <th scope="col">{{ __('generic.action') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($landlessApplications as $key=>$landlessApplication)
                                                    <tr class="text-center">
                                                        <th scope="row">{{ \App\Helpers\Classes\NumberToBanglaWord::engToBn(++$key) }}</th>
                                                        <td>{{ $landlessApplication->application_number }}</td>
                                                        <td>{{ $landlessApplication->nothi_number }}</td>
                                                        <td>{{ $landlessApplication->receipt_number }}</td>
                                                        <td>
                                                            <a href="{{ route('landless.my-application', $landlessApplication->id) }}" class="btn btn-success">{{ __('generic.view_application') }}</a>
                                                            <a href="{{ route('landless.my-receipt', $landlessApplication->id) }}" class="btn btn-info">{{ __('generic.receipt') }}</a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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

                <div class="col-md-12">
                    <div class="p-4">
                        <h3 class="text-center">????????? ???????????? ???????????? ????????????</h3>
                        <div class="row">
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">????????? ????????? ???????????? ?????????????????? (????????????)</th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">????????????.??????</b>
                                            <p>????????????</p>
                                        </td>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">????????????.??????</b>
                                            <p>???????????????</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">?????????????????????????????????????????? ????????? ???????????? ?????????????????? (????????????)
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">????????????.??????</b>
                                            <p>????????????</p>
                                        </td>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">????????????.??????</b>
                                            <p>???????????????</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">??????????????????????????? ????????????????????? ????????????????????? ????????????????????????
                                            ??????????????????
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success"
                                               style="font-size: 20px;display: block;padding: 20px;}">
                                                ????????????
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center"> ??????????????????????????? ??????????????????????????? ????????? ???????????? ??????????????????
                                            (????????????)
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success"
                                               style="font-size: 20px;display: block;padding: 20px;}">
                                                ????????????.??????
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
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

