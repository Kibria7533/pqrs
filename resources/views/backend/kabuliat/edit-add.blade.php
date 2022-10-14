@php
    $edit = !empty($locDistrict->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')
@section('title')
    {{!$edit ? __('generic.jamabandi_create'): __('generic.jamabandi_edit')}}
@endsection
@section('content')
    <div class="modal-header custom-header-bg">
        <h4 class="modal-title">
            {{!$edit ? __('generic.kabuliat'): __('generic.jamabandi_edit')}}
        </h4>
    </div>

    <form class="edit-add-form" method="post"
          action="{{$edit ? route('admin.loc-districts.update', $locDistrict->id) : route('admin.loc-districts.store')}}"
          enctype="multipart/form-data">
        @csrf
        <div class="modal-body pb-0">
            <div class="card card-outline ">
                <div class="card-body row">
                    @if($edit)
                        @method('put')
                    @endif

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">{{ __('generic.settlement_case') }} </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}" placeholder="নম্বর"/>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}" placeholder="বছর"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="bbs_code">{{ __('generic.kabuliat_form_no') }} </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label
                                for="bbs_code">{{ __('generic.district_agricultural_khas_jomi_settlement_committee') }} </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.ulao_proposal_date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label
                                for="bbs_code">{{ __('generic.order_no_of_collector') }} </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label
                                for="bbs_code">{{ __('generic.kabuliat_reg_no') }} </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.ulao_return_date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="application-date">{{ __('generic.occupancy_date') }} </label>
                            <div class="input-group mb-2">
                                <input type="text"
                                       class="flat-date form-control custom-form-control border-right-0 left-border-radius-rounded"
                                       name="title"
                                       id="application-date"
                                       value="{{$edit ? $locDistrict->title : ''}}" placeholder="তারিখ নির্বাচন করুণ"/>
                                <div class="input-group-prepend">
                                    <div class="input-group-text"
                                         style="border-radius: 0 4px 4px 0;border-left: 0;background: #fbfdff;">
                                        <i class="fas fa-calendar-day"
                                           style="color: #959595; transform: rotateY(180deg);"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="overlay" style="display: none">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
            </div>
        </div>

        <div class="px-2 mb-3">
            <div class="text-right">
                <a class="btn btn-success px-5" href="#" role="button">
                    সংরক্ষণ
                </a>
                <a class="btn btn-success px-5" href="#" role="button">
                    রিফ্রেশ
                </a>
            </div>
        </div>

    </form>

@endsection

@push('css')
    <style>

    </style>
@endpush

@push('js')
    <script>
        function settlementLandAreaTemplete() {
            let html = "";
            html += '<div class="row border rounded my-2">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-4">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="form-group">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label>{{ __('generic.dag_number') }} </label>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control custom-form-control" name="dag_number[]"';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=""/>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t</div>';
            html += '';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-4">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="form-group">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label>{{ __('generic.total_land_of_dag') }}</label>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control custom-form-control" name="total_land_of_dag[]"';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value=""/>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t</div>';
            html += '';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-3">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="form-group">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label>{{ __('generic.settlement_proposed') }} </label>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<input type="text" class="form-control custom-form-control" name="settlement_proposed[]"';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t   value="" />';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t</div>';

            html += '\t\t\t\t\t\t\t\t\t\t\t\t<div class="col-md-1">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t<div class="form-group">';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t\t<label>&nbsp; </label>';
            html += '<div><span class="remove btn btn-danger" /><i class="fas fa-backspace"></i></span></div>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t\t</div>';
            html += '\t\t\t\t\t\t\t\t\t\t\t\t</div>';

            html += '\t\t\t\t\t\t\t\t\t\t\t</div>';
            return html;
        }

        $(function () {
            $("#btnAdd").bind("click", function () {
                var div = $("<div />");
                div.html(GetDynamicTextBox(""));
                $("#TextBoxContainer").append(div);
            });
            $("#btnGet").bind("click", function () {
                var values = "";
                $("input[name=DynamicTextBox]").each(function () {
                    values += $(this).val() + "\n";
                });
                alert(values);
            });

            $("body").on("click", ".remove", function () {
                let removeItems = $('.remove').length;

                if (removeItems > 1) {
                    $(this).closest(".row").remove();
                } else {
                    alert('min 1 item is require')
                }
            });
        });

        function GetDynamicTextBox(value) {
            return (settlementLandAreaTemplete);
        }

        $('#TextBoxContainer').append(settlementLandAreaTemplete);


    </script>
@endpush
