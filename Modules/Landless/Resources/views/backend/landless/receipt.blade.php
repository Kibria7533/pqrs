@extends('master::layouts.master')
@section('title')
    {{__('cadt')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.receipt') }} </h3>

                        <div class="card-tools">
                            <div class="btn-group">
                                @can('viewAny', $landless)
                                    <a href="{{route('admin.landless.ac-land.list')}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                                    </a>
                                @endcan
                            </div>

                        </div>
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

@push('js')

@endpush

