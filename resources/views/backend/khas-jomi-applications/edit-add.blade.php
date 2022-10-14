@php
    $edit = !empty($locDistrict->id);
    $authUser = \App\Helpers\Classes\AuthHelper::getAuthUser();
@endphp

@extends('master::layouts.master')
@section('title')
    {{!$edit ? 'আবেদনকারীর বিবরণের এন্ট্রি সম্পাদনা': 'Update আবেদনকারীর বিবরণের এন্ট্রি সম্পাদনা'}}
@endsection
@section('content')
    <div class="modal-header custom-header-bg">
        <h4 class="modal-title">
            {{!$edit ? 'আবেদনকারীর বিবরণের এন্ট্রি সম্পাদনা': 'Update আবেদনকারীর বিবরণের এন্ট্রি সম্পাদনা'}}
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
                            <label>সংশ্লিষ্ট ভুমি ও রাজস্ব অফিস পুরন করিবে</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="application-date">দরখাস্তর প্রাপ্তির তারিখ </label>
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
                            <label for="bbs_code">সময় </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">ক্রমিক নং </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">রশিদ নং </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">নির্বাচিত দরখাস্তকারীর মৌজার নাম </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">{{--জমির শ্রেণী কোড--}} &nbsp; </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-control custom-form-control">
                                        <div class="custom-control custom-radio custom-control-inline h-100"
                                             style="padding: 5px 25px;margin-right: 0 !important;">
                                            <input type="radio" id="land_type_code" name="land_type_code"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="land_type_code">
                                                জমির শ্রেণী কোড পত্র
                                            </label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 pt-4 pb-2">
                        <div class="form-group">
                            <label>দরখাস্তকারীর পরিচয়</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকারীর শ্রেণী </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="submitted_paper">দাখিলকৃত কাগজ পত্র </label>
                            <div class="row d-flex">
                                <div class="col-md-4 mb-1">
                                    <div class="form-control custom-form-control">
                                        <div class="custom-control custom-radio custom-control-inline h-100"
                                             style="padding: 5px 25px;margin-right: 0 !important;">
                                            <input type="radio" id="customRadioInline1" name="submitted_paper"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline1">মুক্তিযোদ্ধার সনদ
                                                পত্র</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <div class="form-control custom-form-control">
                                        <div class="custom-control custom-radio custom-control-inline h-100"
                                             style="padding: 5px 25px;margin-right: 0 !important;">
                                            <input type="radio" id="customRadioInline2" name="submitted_paper"
                                                   class="custom-control-input">
                                            <label class="custom-control-label"
                                                   for="customRadioInline2">ইউনিয়ন/ওয়ার্ড/পৌর</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-1">
                                    <div class="form-control custom-form-control">
                                        <div class="custom-control custom-radio custom-control-inline h-100"
                                             style="padding: 5px 25px;margin-right: 0 !important;">
                                            <input type="radio" id="customRadioInline3" name="submitted_paper"
                                                   class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline3">অন্যান্য</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকারীর নাম </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকারীর বয়স </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকারীর লিঙ্গ </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 pt-4 pb-2">
                        <div class="form-group">
                            <label>দরখাস্তকারীর বাক্তিগত তথ্য ও ঠিকানা</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="bbs_code">দরখাস্তকারীর পিতার নাম </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bbs_code">বয়স </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="bbs_code">দরখাস্তকারীর মাতার নাম </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bbs_code">বয়স </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="bbs_code">দরখাস্তকারীর স্বামীর/স্ত্রির নাম </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="bbs_code">বয়স </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="bbs_code">প/স/ম </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <label for="bbs_code">&nbsp; </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">গ্রাম </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">ইউনিয়ন </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">উপজেলা </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">জেলা </label>
                            <select class="form-control custom-form-control">
                                <option>নির্বাচন করুন</option>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">পরিবারের সদস্য নাম </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">বসত ভিতার বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">পিতা/মাতার পূর্বে পাওয়া খাস জমির বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকৃত খাস জায়গা বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">নথি ভাঙ্গা পরিবারের বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">শহিদ বা পঙ্গু মুক্তিযোদ্ধার বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকারীর দখলে খাস জমির বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্তকারীর কোন বিশেষ খাস জমি পাইতে চাইলে তাহার কারন ও বিবরণ </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">দরখাস্ত ফরম পুরনকারীর নাম </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">প্রার্থীত জায়গা বন্দোবস্ত দেও্যা সম্ভব না হলে অন্য কোন এলাকা হইতে
                                চাহেন </label>
                            <input type="text" class="form-control custom-form-control" name="bbs_code"
                                   value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bbs_code">পদবি </label>
                                    <input type="text" class="form-control custom-form-control" name="bbs_code"
                                           value="{{$edit ? $locDistrict->bbs_code : ''}}"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bbs_code">ফাইল আপলোড </label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01"
                                              style="background: #50177c33;">
                                           <i class="fas fa-upload"></i>&nbsp; আপলোড
                                        </span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input custom-form-control "
                                                   id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bbs_code">ঠিকানা </label>
                            <textarea class="form-control custom-form-control" rows="5"
                                      style="height: 130px"></textarea>
                        </div>
                    </div>

                </div>
                <div class="overlay" style="display: none">
                    <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                </div>
            </div>
        </div>

        <div class="px-2 mb-3">
            <a class="btn btn-success " href="#" role="button">
                &nbsp;<i class="fas fa-less-than"></i>&nbsp;
            </a>

            <a class="btn btn-success " href="#" role="button">
                &nbsp;<i class="fas fa-greater-than"></i>&nbsp;
            </a>

            <a class="btn btn-success px-5" href="#" role="button">
                যোগ
            </a>
            <a class="btn btn-success px-5" href="#" role="button">
                সংরক্ষণ
            </a>
            <a class="btn btn-success px-5" href="#" role="button">
                অ্যাপ নির্বাচন
            </a>
            <a class="btn btn-success px-5" href="#" role="button">
                রিফ্রেশ
            </a>
            <a class="btn btn-danger px-5" href="#" role="button">
                মুছুন
            </a>
            <a class="btn btn-danger px-5" href="#" role="button">
                প্রস্থান করুণ
            </a>
        </div>
    </form>

@endsection

@push('css')
    <style>

    </style>
@endpush
