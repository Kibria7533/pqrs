@extends('master::layouts.master')
@section('title')
    {{__('generic.landless')}}
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" id="print-area">
                    <div class="card-header custom-header-bg">
                        <h3 class="card-title font-weight-bold">{{ __('generic.kabuliat_details') }} </h3>


                        <div class="card-tools">
                            <div class="btn-group">
                                @can('update', $kabuliat)
                                    <a href="{{route('admin.kabuliats.edit', [$kabuliat->id])}}"
                                       class="btn btn-sm btn-primary btn-rounded">
                                        <i class="fas fa-plus-circle"></i> {{ __('generic.edit_button_label') }}
                                    </a>
                                @endcan
                                @can('viewAny', $kabuliat)
                                    <a href="{{route('admin.kabuliats.index')}}"
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
                                <table class="table table-hover table-bordered table-rounded">
                                    <thead>
                                    <tr>
                                        <th>{{ __('generic.settlement_case'). ' ('. __('generic.number').')' }}</th>
                                        <td>{{ $kabuliat->case_no }}</td>
                                        <th>{{ __('generic.settlement_case'). ' ('. __('generic.year').')' }}</th>
                                        <td>{{ $kabuliat->case_year  }}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th width="18%">{{ __('generic.settlement_case'). ' ('. __('generic.date').')' }}
                                            :
                                        </th>
                                        <td width="32%">{{ $kabuliat->case_date  }}</td>
                                        <th width="18%">{{ __('generic.kabuliat_form_no') }}</th>
                                        <td width="32%">{{ $kabuliat->form_no  }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('generic.kabuliat_date') }}</th>
                                        <td>{{ $kabuliat->form_date  }}</td>
                                        <th>{{ __('generic.district_agricultural_khas_jomi_settlement_committee').' '.__('generic.name') }}</th>
                                        <td>{{ $kabuliat->committee_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('generic.district_agricultural_khas_jomi_settlement_committee').' '.__('generic.date') }}</th>
                                        <td>{{ $kabuliat->meeting_date }}</td>
                                        <th>{{ __('generic.ulao_proposal_date') }}</th>
                                        <td>{{ $kabuliat->ulao_proposal_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('generic.collector_order_no') }}</th>
                                        <td>{{ $kabuliat->order_no }}</td>
                                        <th>{{ __('generic.collector_order_date') }}</th>
                                        <td>{{ $kabuliat->order_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('generic.kabuliat_reg_no') }}</th>
                                        <td>{{ $kabuliat->reg_no }}</td>
                                        <th>{{ __('generic.kabuliat_reg_date') }}</th>
                                        <td>{{ $kabuliat->reg_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>{{ __('generic.ulao_return_date') }}</th>
                                        <td>{{ $kabuliat->ulao_return_date }}</td>
                                        <th>{{ __('generic.occupancy_date') }}</th>
                                        <td>{{ $kabuliat->handover_date }}</td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <button class="float-right btn btn-outline-warning px-4" id="print-btn"
                                        onclick="window.print()"><i
                                        class="fas fa-print"></i> {{ __('generic.print') }}</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for  view -->
    <div class="modal fade" id="scan_file_viewer" tabindex="-1" role="dialog"
         aria-labelledby="scan_file_viewerTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scan_file_viewerTitle">
                        {{ __('generic.uploaded_file') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img
                        src="{{ !empty($kabuliat->attached_file)? asset("storage/{$kabuliat->attached_file}"):'' }}"
                        alt="{{ __('generic.uploaded_file') }}" width="100%">
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

            .card-tools, #print-btn {
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

