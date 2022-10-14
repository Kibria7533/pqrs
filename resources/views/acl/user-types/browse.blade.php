@extends('master::layouts.master')
@section('title')
    User Types
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between custom-header custom-bg-gradient-info">
                        <h3 class="card-title font-weight-bold">{{ __('generic.user_type_list') }}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="datatable-container"></div>
                        <table id="dataTable" class="table table-bordered table-striped dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('generic.sl_no') }}</th>
                                    <th>{{ __('generic.code') }}</th>
                                    <th>{{ __('generic.title') }}</th>
                                    <th>{{ __('generic.default_role') }}</th>
                                    <th>{{ __('generic.status') }}</th>
                                    <th>{{ __('generic.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $sl = 0;

                            @endphp
                            @foreach($userTypes as $key=>$userType)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $userType->code }}</td>
                                    <td>{{ $userType->title }}</td>
                                    <td>{{ optional($userType->role)->title }}</td>
                                    <td>{{ !empty($userType->row_status == 0 || $userType->row_status == 1 || $userType->row_status == 99)? $userType->rowStatus->title : ''}}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{route('admin.user-types.edit', $userType->id)}}" class="btn btn-outline-warning btn-sm">
                                                <i class="fas fa-edit"></i> {{ __('generic.edit_button_label') }} </a>
                                            </div>
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
    @include('utils.delete-confirm-modal')
@endsection


