<?php

namespace App\Http\Controllers\Portal;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LandlessUser;
use App\Models\LocAllMouja;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUnion;
use App\Models\LocUpazila;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Models\LandlessApplicationAttachment;

class LandlessUserController extends BaseController
{
    public function __construct()
    {
        /*$this->middleware(function () {
            if (!empty(AuthHelper::getAuthUser())) {
                return redirect()->route('admin.dashboard');
            }
        })*/;
        //$this->middleware('auth:landless');
    }

    /**
     * Show the application dashboard.
     * @return View
     */
    public function home()
    {
        if(Auth::guard('landless')->check()){
            return \view('landless-portal.my-profile');
        }else{
            return redirect()->route('home');
        }
    }

    public function myApplications()
    {
        if(Auth::guard('landless')->check()){
            $landlessUser = LandlessUser::find(Auth::guard('landless')->user()->id);

            $landlessApplications = Landless::where(['email'=> $landlessUser->email])->get();

            return \view('landless-portal.my-application-list', compact('landlessApplications'));
        }
    }

    public function myReceipt($id)
    {
        if(Auth::guard('landless')->check()){
            $landlessUser = LandlessUser::find(Auth::guard('landless')->user()->id);

            $landless = Landless::where(['id'=> $id])->first();

            if($landlessUser->email!= $landless->email){
                abort(404, "আপনার কার্যক্রম সম্পাদন করা সম্ভব নয়");
            }

            $locDivision = LocDivision::where('bbs_code', $landless->loc_division_bbs)->first();
            $locDistrict = LocDistrict::where([
                'division_bbs_code' => $landless->loc_division_bbs,
                'bbs_code' => $landless->loc_district_bbs,
            ])->first();

            $locUpazila = LocUpazila::where([
                'division_bbs_code' => $landless->loc_division_bbs,
                'district_bbs_code' => $landless->loc_district_bbs,
                'bbs_code' => $landless->loc_upazila_bbs,
            ])->first();

            $mouja = LocAllMouja::where([
                'division_bbs_code' => $landless->loc_division_bbs,
                'district_bbs_code' => $landless->loc_district_bbs,
                'upazila_bbs_code' => $landless->loc_upazila_bbs,
                'rs_jl_no' => $landless->jl_number,
            ])->first();


            return view('landless-portal.my-receipt', compact('landless','locDivision','locDistrict','locUpazila','mouja'));

            //return \view('landless-portal.my-receipt', compact('landless'));
        }
    }

    public function myApplication($id)
    {
        if(Auth::guard('landless')->check()){
            $landlessUser = LandlessUser::find(Auth::guard('landless')->user()->id);

            $landless = Landless::where(['id'=> $id])->first();

            $locDivision = LocDivision::where('bbs_code', $landless->loc_division_bbs)->first();
            $locDistrict = LocDistrict::where([
                'division_bbs_code' => $landless->loc_division_bbs,
                'bbs_code' => $landless->loc_district_bbs,
            ])->first();

            $locUpazila = LocUpazila::where([
                'division_bbs_code' => $landless->loc_division_bbs,
                'district_bbs_code' => $landless->loc_district_bbs,
                'bbs_code' => $landless->loc_upazila_bbs,
            ])->first();

            $locUnion = LocUnion::where([
                'division_bbs_code' => $landless->loc_division_bbs,
                'district_bbs_code' => $landless->loc_district_bbs,
                'upazila_bbs_code' => $landless->loc_upazila_bbs,
                'bbs_code' => $landless->loc_union_bbs,
            ])->first();


            if (Session::get('locale') == 'en') {
                $locDivision = !empty($locDivision) ? $locDivision->title_en : '';
                $locDistrict = !empty($locDistrict) ? $locDistrict->title_en : '';
                $locUpazila = !empty($locUpazila) ? $locUpazila->title_en : '';
                $locUnion = !empty($locUnion) ? $locUnion->title_en : '';

            } else {
                $locDivision = !empty($locDivision) ? $locDivision->title : '';
                $locDistrict = !empty($locDistrict) ? $locDistrict->title : '';
                $locUpazila = !empty($locUpazila) ? $locUpazila->title : '';
                $locUnion = !empty($locUnion) ? $locUnion->title : '';
            }

            $landlessApplicationAttachments = LandlessApplicationAttachment::where('landless_application_id', $landless->id)->get();

            return view('landless-portal.my-application-read', compact('landless', 'locDivision', 'locDistrict', 'locUpazila', 'locUnion','landlessApplicationAttachments'));
        }
    }
}
