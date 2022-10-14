<?php

namespace App\Http\Controllers\Designation;

use App\Http\Controllers\BaseController;
use App\Services\DesignationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Designation;

class DesignationsController extends BaseController{
    const VIEW_PATH = 'backend.designations.';

    protected DesignationService $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
        $this->authorizeResource(Designation::class);
    }

    public function index(): View{
        return \view(self::VIEW_PATH . 'browse');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $designation = new Designation();
        return \view(self::VIEW_PATH . 'Edit-add', compact('designation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->designationService->validator($request->all())->validate();

        try {
            $this->designationService->createDesignation($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_created_successfully', ['object' => 'Designation']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Designation $designation
     * @return View
     */
    public function show(Designation $designation): View
    {
        return \view(self::VIEW_PATH . 'read', compact('designation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Designation $designation
     * @return View
     */
    public function edit(Designation $designation):view
    {
        return \view(self::VIEW_PATH . 'edit-add', compact('designation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Designation $designation
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request,Designation $designation): RedirectResponse
    {
        $validatedData = $this->designationService->validator($request->all(), $designation->id)->validate();

        try {
            $this->designationService->updateDesignation($designation, $validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'Designation']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Designation $designation
     * @return RedirectResponse
     */
    public function destroy(Designation $designation): RedirectResponse
    {
        try {
            $this->designationService->deleteDesignation($designation);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'Designation']),
            'alert-type' => 'success'
        ]);
    }

    public function getDatatable(Request $request): JsonResponse
    {
        return $this->designationService->getListDataForDatatable($request);
    }

}
