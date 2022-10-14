<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\LocDistrict;
use App\Models\LocMouja;
use App\Models\LocUnion;
use App\Models\LocUpazila;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    public function getDistricts(Request $request)
    {
        return LocDistrict::where('division_bbs_code', $request->division_bbs_code)->get();
    }

    public function getUpazilas(Request $request)
    {
        return LocUpazila::where('district_bbs_code', $request->district_bbs_code)->get();
    }

    public function getUnions(Request $request)
    {
        return LocUnion::where([
            'division_bbs_code' => $request->division_bbs_code,
            'district_bbs_code' => $request->district_bbs_code,
            'upazila_bbs_code' => $request->upazila_bbs_code,
        ])->get();
    }

    public function getMoujas(Request $request)
    {
        return LocMouja::where([
            'division_bbs_code' => $request->division_bbs_code,
            'district_bbs_code' => $request->district_bbs_code,
            'upazila_bbs_code' => $request->upazila_bbs_code,
        ])->get();
    }
}
