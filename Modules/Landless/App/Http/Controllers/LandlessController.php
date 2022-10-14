<?php

namespace Modules\Landless\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocAllMouja;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use App\Models\LocUnion;
use App\Models\LocUpazila;
use App\Models\Office;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Landless\App\Models\FileType;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Models\LandlessApplicationAttachment;
use Modules\Landless\App\Services\LandlessService;
use Modules\Meeting\Models\LandlessMeeting;
use Modules\Meeting\Models\Meeting;

class LandlessController extends BaseController
{
    protected LandlessService $landlessService;
    private const VIEW_PATH = 'landless::backend.landless.';

    public function __construct(LandlessService $landlessService)
    {
        $this->landlessService = $landlessService;
        $this->authorizeResource(Landless::class);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     **/
    public function index()
    {
        $locUpazilas = LocUpazila::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE, //20 for CTG division bbs code
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE, //75 for loc_district_bbs,
        ])->get();
        return view(self::VIEW_PATH . 'browse', compact('locUpazilas'));
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create(): View
    {
        $locDivisions = LocDivision::all();
        $fileTypes = FileType::all();
        return \view(self::VIEW_PATH . 'edit-add', compact('locDivisions', 'fileTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->landlessService->validator($request);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        /**
         * File type ext validation
         **/
        foreach ($request->attachments as $key => $attachment) {
            if (!empty($attachment['attached_file'])) {
                $fileType = FileType::find($attachment['file_type_id']);
                $fileExt = $attachment['attached_file']->extension();
                $allowFormats = explode(',', $fileType->allow_format);
                $fileExtSearch = array_search($fileExt, $allowFormats);

                if ($fileExtSearch === false) {
                    return response()->json([
                        'message' => __("attachments.$key.attached_file ফাইল এর ধরণ $fileType->allow_format এর ভিতর যেকোনো একটি প্রদান করুন!"),
                        'alertType' => 'error',
                    ], 200);
                }
            }
        }

        $data = $validatedData->validate();

        if ($data['status'] == Landless::STATUS_DRAFT) {
            $data['stage'] = Landless::STAGE_INITIAL;
        }

        if ($data['status'] == Landless::STATUS_ON_PROGRESS) {
            $data['stage'] = Landless::STAGE_ACLAND_SENDING;
        }

        $authUser = AuthHelper::getAuthUser();
        $office = Office::find($authUser->office_id);

        if (!empty($office) && $data['loc_upazila_bbs'] != $office->upazila_bbs_code) {
            $data['loc_division_bbs'] = $office->loc_division_bbs;
            $data['loc_district_bbs'] = $office->loc_district_bbs;
            $data['loc_upazila_bbs'] = $office->upazila_bbs_code;
        }

        try {
            $this->landlessService->createLandless($data);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.landless_not_added'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.landless_added'),
            'alertType' => 'success',
            'redirectTo' => route('admin.landless.create'),
        ]);
    }

    /**
     * Show the specified resource.
     * @param Landless $landless
     * @return Renderable
     */
    public function show(Landless $landless)
    {
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

       $meetings=Meeting::leftJoin('landless_meeting', function($join) use($landless){
            $join->on('meetings.id', '=', 'landless_meeting.meeting_id')
                ->where('landless_meeting.landless_id','=', $landless->id);
        })
           ->whereNotNull('landless_meeting.landless_id')
            ->get();
        return view(self::VIEW_PATH . '.read', compact('landless', 'locDivision', 'locDistrict', 'locUpazila', 'locUnion','landlessApplicationAttachments','meetings'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Request $request
     * @param Landless $landless
     * @return View
     */
    public function edit(Request $request, Landless $landless): View
    {
        $landlessApplicationAttachments = LandlessApplicationAttachment::where('landless_application_id', $landless->id)->get();

        $locDivisions = LocDivision::all();
        $districts = LocDistrict::where([
            'division_bbs_code' => $landless->loc_division_bbs,
        ])->get();

        $upazilas = LocUpazila::where([
            'division_bbs_code' => $landless->loc_division_bbs,
            'district_bbs_code' => $landless->loc_district_bbs,
        ])->get();

        $unions = LocUnion::where([
            'division_bbs_code' => $landless->loc_division_bbs,
            'district_bbs_code' => $landless->loc_district_bbs,
            'upazila_bbs_code' => $landless->loc_upazila_bbs,
        ])->get();

        $moujas = LocAllMouja::where([
            'division_bbs_code' => $landless->loc_division_bbs,
            'district_bbs_code' => $landless->loc_district_bbs,
            'upazila_bbs_code' => $landless->loc_upazila_bbs,
        ])->get();

        $fileTypes = FileType::all();

        return \view(self::VIEW_PATH . '.edit-add', compact('locDivisions', 'districts', 'upazilas', 'unions', 'landless', 'fileTypes', 'moujas', 'landlessApplicationAttachments'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param Landless $landless
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Request $request, Landless $landless): JsonResponse
    {
        $validatedData = $this->landlessService->validator($request, $landless->id);

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return response()->json([
                'message' => __($errors->first()),
                'alertType' => 'error',
            ], 200);
        }

        foreach ($request->attachments as $key => $attachment) {
            if (empty($attachment['attachment_id']) && empty($attachment['attached_file'])) {
                return response()->json([
                    'message' => __("attachments.$key.attached_file is require"),
                    'alertType' => 'error',
                ], 200);
            }

            if (empty($attachment['attachment_id']) && !empty($attachment['attached_file'])) {
                $fileType = FileType::find($attachment['file_type_id']);
                $fileExt = $attachment['attached_file']->extension();
                $allowFormats = explode(',', $fileType->allow_format);
                $fileExtSearch = array_search($fileExt, $allowFormats);

                if ($fileExtSearch === false) {
                    return response()->json([
                        'message' => __("attachments.$key.attached_file ফাইল এর ধরণ $fileType->allow_format এর ভিতর যেকোনো একটি প্রদান করুন!"),
                        'alertType' => 'error',
                    ], 200);
                }
            }
        }

        $data = $validatedData->validate();

        if ($request->identity_type == Landless::IDENTITY_TYPE_NOT_AVAILABLE) {
            $data['identity_number'] = null;
        }

        $authUser = AuthHelper::getAuthUser();
        $office = Office::find($authUser->office_id);

        if (!empty($office) && $data['loc_upazila_bbs'] != $office->upazila_bbs_code) {
            $data['loc_division_bbs'] = $office->loc_division_bbs;
            $data['loc_district_bbs'] = $office->loc_district_bbs;
            $data['loc_upazila_bbs'] = $office->upazila_bbs_code;
        }

        try {
            $this->landlessService->updateLandless($data, $landless);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.landless_not_updated'),
                'alertType' => 'error',
            ], 200);
        }

        return response()->json([
            'message' => __('generic.landless_updated'),
            'alertType' => 'success',
            'redirectTo' => route('admin.landless.index'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Landless $landless
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Landless $landless)
    {
        try {
            $this->landlessService->deleteLandless($landless);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return redirect(route('admin.landless.index'))->with([
                'message' => __('generic.landless_not_removed'),
                'alert-type' => 'error',
            ]);

        }

        return redirect(route('admin.landless.index'))->with([
            'message' => __('generic.landless_removed'),
            'alert-type' => 'success',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->landlessService->getListDataForDatatable($request);
    }

    public function approve(Landless $landless)
    {
        /**
         * Manually authorize Policy apply for single Approve
         **/
        $this->authorize('singleApprove', $landless);

        try {
            $this->landlessService->approveSingleLandless($landless);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.landless_not_approved'),
                'alertType' => 'error',
            ], 200);
        }

        return redirect()->route('admin.landless.index')->with([
            'message' => __('generic.landless_approved'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.landless.index'),
        ]);
    }


    public function approveToMeeting(int $landlessId,int $meetingId)
    {
        /**
         * Manually authorize Policy apply for single Approve
         **/
        try {
            $metting = Meeting::find($meetingId);
            $landless = Landless::where('status',Landless::STATUS_ACTIVE)
                                 ->where('is_land_assigned',0)
                                 ->first();

            if (!$metting || !$landless)
            {
                return redirect()->back()->with([
                    'message' => __('generic.landless_meeting_error'),
                    'alert-type' => 'error',
                ]);
            }

            $landLessMeeting = new LandlessMeeting();
            $landLessMeeting->meeting_id = $meetingId;
            $landLessMeeting->landless_id = $landlessId;
            $landLessMeeting->save();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return redirect()->back()->with([
                'message' => __('generic.landless_approved_error'),
                'alert-type' => 'error',
            ]);
        }

        return redirect()->route('admin.meeting_management.landless-applicants-list',$meetingId)->with([
            'message' => __('generic.landless_approved'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.meeting_management.landless-applicants-list',$meetingId),
        ]);
    }

    public function rejectFromMeeting(int $landlessId,int $meetingId)
    {
        /**
         * Manually authorize Policy apply for single Approve
         **/

        try {
            $landLessMeeting = LandlessMeeting::where('landless_id', $landlessId)->where('meeting_id',$meetingId)->firstOrFail();
            $landLessMeeting->delete();
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.landless_not_approved'),
                'alertType' => 'error',
            ], 200);
        }

        return redirect()->route('admin.meeting_management.landless-applicants-list',$meetingId)->with([
            'message' => __('generic.landless_not_approved'),
            'alert-type' => 'error',
            'redirectTo' => route('admin.meeting_management.landless-applicants-list',$meetingId),
        ]);
    }

    public function multiApprove(Request $request)
    {
        /**
         * Manually authorize Policy apply for multi Approve
         **/
        $this->authorize('multiApprove', Landless::class);

        DB::beginTransaction();
        try {
            $validatedData = $this->landlessService->validateLandlessMultiApproveOrReject($request);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();


            $this->landlessService->multiApproveLandless($data['landless_ids']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.landless_not_approved'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.landless_approved'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.landless.index'),
        ]);
    }

    public function reject(Landless $landless)
    {
        /**
         * Manually authorize Policy apply for single reject
         **/
        $this->authorize('singleReject', $landless);

        try {
            $this->landlessService->rejectSingleLandless($landless);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.landless_not_reject'),
                'alertType' => 'error',
            ], 200);
        }

        return redirect()->route('admin.landless.index')->with([
            'message' => __('generic.landless_reject'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.landless.index'),
        ]);
    }

    public function multiReject(Request $request)
    {
        /**
         * Manually authorize Policy apply for multi reject
         **/
        $this->authorize('multiReject', Landless::class);

        DB::beginTransaction();
        try {
            $validatedData = $this->landlessService->validateLandlessMultiApproveOrReject($request);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();


            $this->landlessService->rejectMultiLandless($data['landless_ids']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.landless_not_reject'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.landless_reject'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.landless.index'),
        ]);

    }

    public function showKabuliat(Landless $landless)
    {
        return view(self::VIEW_PATH . 'read-kabuliat', compact('landless'));
    }

    /**
     * NID verification
     **/
    public function getUserInfoFromNidApi(Request $request): JsonResponse
    {
        return $this->landlessService->nidVerification($request);
    }

    public function checkAllowFormat(FileType $fileType, Request $request): JsonResponse
    {
        $fileExt = $request->file_ext;
        $allowFormats = explode(',', $fileType->allow_format);
        $fileExtSearch = array_search($fileExt, $allowFormats);

        if ($fileExtSearch === false) {
            return response()->json("ফাইল এর ধরণ $fileType->allow_format এর ভিতর যেকোনো একটি প্রদান করুন!");
        } else {
            return response()->json(true);
        }
    }

    public function checkNothiNumber(Request $request): JsonResponse
    {
        $landlessApplications = Landless::where('nothi_number', $request->nothi_number)->first();

        if (!empty($landlessApplications)) {
            if (!empty($request->id)) {
                if ($landlessApplications->id != $request->id) {
                    return response()->json("ইতিমধ্যে এই নথি নম্বর যোগ করা হয়েছে!");
                } else {
                    return response()->json(true);
                }
            } else {
                return response()->json("ইতিমধ্যে এই নথি নম্বর যোগ করা হয়েছে!");
            }
        } else {
            return response()->json(true);
        }
    }

    public function receipt(Landless $landless)
    {
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


        return view(self::VIEW_PATH . 'receipt', compact('landless','locDivision','locDistrict','locUpazila','mouja'));
    }

    public function aclandAprovedList()
    {
        $locUpazilas = LocUpazila::where([
            'division_bbs_code' => Landless::CTG_BBS_CODE, //20 for CTG division bbs code
            'district_bbs_code' => Landless::NOAKHALI_BBS_CODE, //75 for loc_district_bbs,
        ])->get();
        return view(self::VIEW_PATH . 'ac-land-approved.browse', compact('locUpazilas'));
    }

    public function getAclandaAprovedDatatable(Request $request): JsonResponse
    {
        return $this->landlessService->getListDataForAcLandApprovedDatatable($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getApplicantsDatatable(Request $request,int $meeting):JsonResponse
    {

        return $this->landlessService->getLandlessListDataForDatatable($request,$meeting);
    }

    public function applicantsShow(Landless $landless,int $meetingId)
    {
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

        $meetings=Meeting::leftJoin('landless_meeting', function($join) use($landless){
            $join->on('meetings.id', '=', 'landless_meeting.meeting_id')
                ->where('landless_meeting.landless_id','=', $landless->id);
        })
            ->whereNotNull('landless_meeting.landless_id')
            ->get();

        return view(self::VIEW_PATH . '.applicants-show', compact('landless', 'locDivision', 'locDistrict', 'locUpazila', 'locUnion','landlessApplicationAttachments','meetings','meetingId'));
    }
}
