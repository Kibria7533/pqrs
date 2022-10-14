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
                                    <h2 class="">{{ __('generic.receipt') }}</h2>
                                </div>
                                <div class="card-body" id="print-area">
                                    <div class="row">
                                        <div class="col-md-10 mx-auto">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="w-100 my-3">
                                                                <tbody>
                                                                <tr>
                                                                    <td colspan="6">
                                                                        <div class="card-header text-center border-bottom-0 p-0">
                                                                            <h3>আবেদনের রশিদ</h3>
                                                                            <p>ভূমি রেকর্ড ব্যবস্থাপনা সিস্টেম, নোয়াখালী।</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th width="10%">{{ __('generic.sl_number') }}</th>
                                                                    <td>: {{ $landless->application_number }}</td>
                                                                    <th width="10%">{{ __('generic.receipt_number') }}</th>
                                                                    <td>: {{ $landless->receipt_number }}</td>
                                                                    <th width="10%">{{ __('generic.date') }}</th>
                                                                    <td>: {{ $landless->application_received_date }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th>{{ __('generic.name_of_the_applicant') }}</th>
                                                                    <td>: {{ $landless->fullname }}</td>
                                                                    <th>&nbsp;</th>
                                                                    <td>&nbsp;</td>
                                                                    <th>{{ __('generic.mobile') }}</th>
                                                                    <td>: {{ $landless->mobile }}</td>
                                                                </tr>

                                                                <tr>
                                                                    <th>{{ __('generic.district') }}</th>
                                                                    <td>: {{ $locDistrict->title }}</td>
                                                                    <th>{{ __('generic.upazila') }}</th>
                                                                    <td>: {{ $locUpazila->title }}</td>
                                                                    <th>{{ __('generic.mouja') }}</th>
                                                                    <td>: {{ $mouja->name_bd }}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-1">
                                                <button class="btn btn-outline-info px-4 float-right" id="print-btn"
                                                        onclick="window.print()"><i
                                                        class="fas fa-print"></i> {{ __('generic.print') }}</button>
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

                <div class="col-md-12">
                    <div class="p-4">
                        <h3 class="text-center">খাস জমির তথ্য ২০২০</h3>
                        <div class="row">
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">মোট খাস জমির পরিমাণ (একরে)</th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>
                                            <p>কৃষি</p>
                                        </td>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>
                                            <p>অকৃষি</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">বন্দোবস্তযোগ্য খাস জমির পরিমাণ (একরে)
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>
                                            <p>কৃষি</p>
                                        </td>
                                        <td class="p-2 text-center">
                                            <b class="text-success" style="font-size: 20px">১০১১.৮১</b>
                                            <p>অকৃষি</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center">বন্দোবস্ত প্রাপ্ত ভূমিহীন পরিবারের
                                            সংখ্যা
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success"
                                               style="font-size: 20px;display: block;padding: 20px;}">
                                                ৩৯৪৩
                                            </b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3 p-1">
                                <table class="table-bordered w-100">
                                    <tr>
                                        <th colspan="2" class="p-2 text-center"> বন্দোবস্ত প্রদানকৃত খাস জমির পরিমাণ
                                            (একরে)
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="p-2 text-center">
                                            <b class="text-success"
                                               style="font-size: 20px;display: block;padding: 20px;}">
                                                ১০১১.৮১
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
        @media print {
            @page {
                size: auto;
                margin: 0mm;
            }

            body * {
                visibility: hidden;
            }

            #print-btn {
                display: none;
            }

            #print-area, #print-area * {
                visibility: visible;
            }

            #print-area {
                margin:0 auto;
                width: 85%;
            }

        }
    </style>
@endpush

