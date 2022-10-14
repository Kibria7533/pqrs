@extends('master::layouts.master')
@section('title')
    {{__('generic.upazila_worksheet')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="print-area">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.worksheet') }} </h3>

                        <div class="card-tools">
                            <div class="btn-group">
                                @can('viewAny', $meeting)
                                    <a href="{{route('admin.meeting_management.meetings.index')}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-backward"></i> {{ __('generic.back_to_list') }}
                                    </a>
                                @endcan
                            </div>

                        </div>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button class="float-right btn btn-outline-info px-4" id="print-btn"
                                        onclick="window.print()"><i
                                        class="fas fa-print"></i> {{ __('generic.print') }}</button>
                            </div>
                            <div class="col-md-10 mx-auto">
                                <div class="">
                                    {!! $worksheetDetails !!}
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

            .card-tools {
                display: none;
            }

            #print-area, #print-area * {
                visibility: visible;
            }

            #print-area {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endpush

