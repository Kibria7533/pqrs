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
            {{!$edit ? __('generic.jamabandi_create'): __('generic.jamabandi_edit')}}
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

                    <div class="col-md-12 py-2">
                        <div class="form-group">
                            <label>{{ __('generic.case_status') }}</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">{{ __('generic.mouja_name') }}</label>
                            <select class="form-control custom-form-control">
                                <option>{{ __('generic.select_placeholder') }}</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

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
                            <label for="application-date">{{ __('generic.case_date') }} </label>
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
                            <label for="bbs_code">{{ __('generic.selected_mouja') }}</label>
                            <select class="form-control custom-form-control">
                                <option>{{ __('generic.select_placeholder') }}</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">{{ __('generic.sl_no') }} </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}" placeholder="ক্রমিক নং লিখুন"/>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="modal-header custom-header-bg py-1">
                            <h5 class="modal-title">
                                {{ __('generic.recipient_name_address') }}
                            </h5>
                        </div>
                        <div class="modal-body border border-top-0 rounded-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.sl_no') }}  </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}" placeholder="ক্রমিক নং"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.name') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.p_s_m') }} </label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control custom-form-control"
                                                           name="bbs_code"
                                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control custom-form-control"
                                                           name="bbs_code"
                                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.father_mother_husband') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.p_s_m') }} </label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control custom-form-control"
                                                           name="bbs_code"
                                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <input type="text" class="form-control custom-form-control"
                                                           name="bbs_code"
                                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.husband_wife') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.upazila') }} </label>
                                        <select class="form-control custom-form-control">
                                            <option>{{ __('generic.select_placeholder') }}</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.father_mother') }}</label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.district') }}  </label>
                                        <select class="form-control custom-form-control">
                                            <option>{{ __('generic.select_placeholder') }}</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.village_house') }} </label>
                                        <select class="form-control custom-form-control">
                                            <option>{{ __('generic.select_placeholder') }}</option>
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.union_or_road_no') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.owner_portion') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="modal-header custom-header-bg py-1">
                            <h5 class="modal-title">
                                {{ __('generic.settlement_land_details') }}
                            </h5>
                        </div>
                        <div class="modal-body border border-top-0 rounded-bottom">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="TextBoxContainer">
                                    </div>
                                    <div class="float-right">
                                        <span id="btnAdd" class="btn btn-success px-5">
                                            <i class="fas fa-plus-circle"></i> {{ __('generic.add_more') }}
                                        </span>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="modal-header custom-header-bg py-1">
                            <h5 class="modal-title">
                                {{ __('generic.other') }}
                            </h5>
                        </div>
                        <div class="modal-body border border-top-0 rounded-bottom">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.total_proposed_land') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.salami') }} </label>
                                        <input type="text" class="form-control custom-form-control" name="bbs_code"
                                               value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bbs_code">{{ __('generic.comments') }} </label>
                                        <textarea class="form-control custom-form-control" rows="5"
                                                  style="height: 130px"></textarea>
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
                                                   value="{{$edit ? $locDistrict->title : ''}}"
                                                   placeholder="তারিখ নির্বাচন করুণ"/>
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
