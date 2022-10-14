<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\LocDivision;
use App\Services\FileTypeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Landless\App\Models\FileType;

class FileTypeController extends BaseController
{
    const  VIEW_PATH = "master::backend.file-types.";

    protected FileTypeService $fileTypeService;

    public function __construct(FileTypeService $fileTypeService)
    {
        $this->fileTypeService = $fileTypeService;
        $this->authorizeResource(FileType::class);
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view(self::VIEW_PATH . 'browse');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $locDivisions = LocDivision::get();
        return \view(self::VIEW_PATH . 'edit-add', compact('locDivisions'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->fileTypeService->validator($request)->validate();

        try {
            $this->fileTypeService->createFileType($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error',
            ]);
        }

        return response()->json([
            'message' => __('generic.object_created_successfully', ['object' => __('generic.file_type')]),
            'alertType' => 'success',
            'redirectTo' => route('admin.file-types.index'),
        ]);
    }

    /**
     * @param FileType $fileType
     * @param Request $request
     * @return View
     */
    public function show(FileType $fileType, Request $request): View
    {
        return \view(self::VIEW_PATH . 'read', compact('fileType'));
    }

    /**
     * @param FileType $fileType
     * @return View
     */
    public function edit(FileType $fileType): View
    {
        if (!empty($fileType->allow_format)) {
            $fileTypes = explode(',', $fileType->allow_format);
        } else {
            $fileTypes = [];
        }

        return \view(self::VIEW_PATH . 'edit-add', compact('fileType', 'fileTypes'));
    }

    /**
     * @param FileType $fileType
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(FileType $fileType, Request $request): JsonResponse
    {
        $validatedData = $this->fileTypeService->validator($request, $fileType->id)->validate();

        try {
            $this->fileTypeService->updateFileType($validatedData, $fileType);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.something_wrong_try_again'),
                'alertType' => 'error',
                'redirectTo' => route('admin.file-types.index'),
            ]);
        }

        return response()->json([
            'message' => __('generic.object_updated_successfully', ['object' => __('generic.file_type')]),
            'alertType' => 'success',
            'redirectTo' => route('admin.file-types.index'),
        ]);

    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param FileType $fileType
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(FileType $fileType)
    {
        try {
            $this->fileTypeService->deleteFileType($fileType);
        } catch (\Exception $exception) {
            return redirect(route('admin.file-types.index'))->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error',
            ]);
        }

        return redirect(route('admin.file-types.index'))->with([
            'message' => __('generic.object_deleted_successfully', ['object' => __('generic.file_type')]),
            'alert-type' => 'success',
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDatatable(Request $request): JsonResponse
    {
        return $this->fileTypeService->getListDataForDatatable($request);
    }
}
