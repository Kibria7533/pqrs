<?php

namespace Modules\Khotian\App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LocDistrict;
use App\Models\LocDivision;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Khotian\App\Models\KhasLandKhotian;
use Modules\Khotian\App\Services\KhasLandKhotianService;
use PDF;

class KhasLandKhotianController extends BaseController
{
    protected KhasLandKhotianService $khasLandKhotianService;
    private const VIEW_PATH = 'khotian::backend.khas-land-khotian.';

    public function __construct(KhasLandKhotianService $khasLandKhotianService)
    {
        $this->khasLandKhotianService = $khasLandKhotianService;
    }

    public function index()
    {
        $this->authorize('viewAny', KhasLandKhotian::class);
        $locDivision = LocDivision::where('bbs_code', '=', 20)->first();
        $locDistrict = LocDistrict::where(['bbs_code' => 75, 'division_bbs_code' => 20])->first();
        return view(self::VIEW_PATH . '.browse', compact('locDivision', 'locDistrict'));
    }

    public function show(KhasLandKhotian $khaslandKhotian)
    {
        $this->authorize('view', app(KhasLandKhotian::class));
        $batch_khotians =$khaslandKhotian->getKhatianPrintJson(
            $khaslandKhotian->division_bbs_code,
            $khaslandKhotian->district_bbs_code,
            $khaslandKhotian->upazila_bbs_code,
            $khaslandKhotian->jl_number,
            $khaslandKhotian->khotian_number
        );
        if(empty($batch_khotians)){
            return redirect()->back()->with([
                'message' => 'Pdf not found',
                'alertType' => 'error',
            ]);
        }
        $print_type = 2;
        $formatedIP = '';
        $userCode = '';
        $formatedIpPartOne = '66';
        $formatedIpPartTwo = '44';
        $print_type = 2;
        $bg = \url('img/watermark-bg.png');

        $html = view(
            self::VIEW_PATH.'.khotian-pdf_backup',
            compact('khaslandKhotian','batch_khotians', 'print_type', 'bg', 'print_type', 'formatedIP', 'userCode', 'formatedIpPartOne', 'formatedIpPartTwo',)
        )
        ->render();

        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => Config::get('pdf.font_path'),
            'fontdata' => Config::get('pdf.font_data'),
            'tempDir' => storage_path('tempdir'),
            'default_font' => 'kalpurush',
            'format' => 'Letter-L',
        ]);
        $mpdf->shrink_tables_to_fit = 0;
        $mpdf->use_kwt = true;
        $mpdf->keep_table_proportions = true;
        $mpdf->SetProtection(array('print'), null, '22hellohello22');
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        die;
    }

    public function search()
    {
        $this->authorize('create', app(KhasLandKhotian::class));
        $locDivision = LocDivision::where('bbs_code', '=', '20')->first();
        $locDistrict = LocDistrict::where(['bbs_code' => 75, 'division_bbs_code' => 20])->first();
        return view(self::VIEW_PATH . '.search', compact('locDivision', 'locDistrict'));
    }

    public function searchKhotian(Request $request)
    {
        $this->authorize('create', app(KhasLandKhotian::class));

        $khasLanKhotian = KhasLandKhotian::where([
            'division_bbs_code' => $request->division_bbs_code,
            'district_bbs_code' => $request->district_bbs_code,
            'upazila_bbs_code' => $request->upazila_bbs_code,
            'jl_number' => $request->jl_number,
            'khotian_number' => $request->khotian_number,
        ])->first();

        if (!empty($khasLanKhotian)) {
            return response()->json([
                'local-status' => true,
                'local-message' => __('generic.khas_land_khotian_already_exists'),
                'local-data' => $khasLanKhotian,
            ], 200);
        } else {
            /** start of api call*/
            $login_data = apiLoginData();

            if ($login_data['success']) {

                $headers_khotian = array(
                    "content-type: application/json",
                    'Authorization' => 'Authorization: Bearer ' . $login_data['access_token']
                );

                $data_khotian = array(
                    'division_bbs_code' => $request->division_bbs_code,
                    'district_bbs_code' => $request->district_bbs_code,
                    'upazila_bbs_code' => $request->upazila_bbs_code,
                    'jl_number' => $request->jl_number,
                    'khotian_number' => $request->khotian_number,
                );
                $url_khotian = "http://v2.utility.eporcha.gov.bd/api/v1/get-khasland-khotian/" . $request->khotian_number;


                $return_data_khotian = apiGetKhotian($url_khotian, $headers_khotian, $data_khotian);

            }
            /** end of api call*/

            $url_khotian = "http://v2.utility.eporcha.gov.bd/api/v1/get-khasland-khotian/" . $request->khotian_number;
            $response = apiGetKhotian($url_khotian, $headers_khotian, $data_khotian);

            if (!$request->is_save) {
                return $response['body'];
            } else {

                $validatedData = $this->khasLandKhotianService->validator($response['body']['data']);

                if ($validatedData->fails()) {
                    $errors = $validatedData->errors()->messages();
                    foreach ($errors as $key => $value) {
                        return response()->json([
                            'message' => $key . ":" . implode(" ", $value),
                            'alertType' => 'error',
                        ], 200);
                    }
                }

                $data = $validatedData->validate();

                try {
                    $this->khasLandKhotianService->createKhasLandKhotian($data);
                } catch (\Throwable $exception) {
                    Log::debug($exception->getMessage());
                    Log::debug($exception->getTraceAsString());

                    return response()->json([
                        'message' => __('generic.khas_land_khotian_not_saved'),
                        'alertType' => 'error',
                    ], 200);
                }

                return response()->json([
                    'message' => __('generic.khas_land_khotian_saved'),
                    'alertType' => 'success',
                    'redirectTo' => route('admin.khotians.khasland-khotian'),
                ], 200);
            }

        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->khasLandKhotianService->getListDataForDatatable($request);
    }

    public function approve(KhasLandKhotian $khaslandKhotian)
    {
        $this->authorize('singleApprove', KhasLandKhotian::class);
        try {
            $this->khasLandKhotianService->approveKhasLandKhotian($khaslandKhotian);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.khasland_khotian_not_approved'),
                'alertType' => 'error',
            ], 200);
        }

        return redirect()->route('admin.khotians.khasland-khotians.index')->with([
            'message' => __('generic.khasland_khotian_approved'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.khotians.khasland-khotians.index'),
        ]);
    }


    public function khaslandKhotianApprove(Request $request)
    {
        $this->authorize('create', KhasLandKhotian::class);
        DB::beginTransaction();
        try {
            $validatedData = $this->khasLandKhotianService->validateKhaslandKhotianApproveNow($request);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();

            $this->khasLandKhotianService->khaslandKhotianApprove($data['khasland_khotian_ids']);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.khasland_khotian_not_approved'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.khasland_khotian_approved'),
            'alert-type' => 'success',
            'redirectTo' => route('admin.khotians.khasland-khotians.index'),
        ]);
    }

}
