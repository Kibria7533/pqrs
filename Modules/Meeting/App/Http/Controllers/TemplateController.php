<?php

namespace Modules\Meeting\App\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Modules\Meeting\App\Services\TemplateService;
use Modules\Meeting\Models\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class TemplateController extends BaseController
{
    const VIEW_PATH = 'meeting::backend.templates.';
    protected TemplateService $templateService;

    public function __construct(TemplateService $templateService)
    {
        $this->templateService = $templateService;
        $this->authorizeResource(Template::class);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view(self::VIEW_PATH . 'browse');
    }


    public function create()
    {
        return view(self::VIEW_PATH . 'edit-add');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $this->templateService->validator($request);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }

            $data = $validatedData->validate();

            $this->templateService->createTemplate($data);

            return response()->json([
                'message' => __('generic.template_added'),
                'alertType' => 'success',
                'redirectTo' => route('admin.meeting_management.templates.index'),
            ]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.template_not_added'),
                'alertType' => 'error',
            ], 200);
        }
    }

    /**
     * Show the specified resource.
     * @param Template $template
     * @return Renderable
     */
    public function show(Template $template)
    {
        return view(self::VIEW_PATH . 'read', compact('template', 'template'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param template $template
     * @return Renderable
     */
    public function edit(Template $template)
    {
        return view(self::VIEW_PATH . 'edit-add', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param template $template
     * @return JsonResponse
     */
    public function update(Request $request, Template $template): JsonResponse
    {
        try {
            $validatedData = $this->templateService->validator($request, $template->id);

            if ($validatedData->fails()) {
                $errors = $validatedData->errors();

                return response()->json([
                    'message' => __($errors->first()),
                    'alertType' => 'error',
                ], 200);
            }
            $data = $validatedData->validate();

            $this->templateService->updateTemplate($data, $template);

            return response()->json([
                'message' => __('generic.template_update_success'),
                'alertType' => 'success',
                'redirectTo' => route('admin.meeting_management.templates.index'),
            ]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());

            return response()->json([
                'message' => __('generic.template_update_failed'),
                'alertType' => 'error',
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param Template $template
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(Template $template)
    {
        try {
            $this->templateService->deleteTemplate($template);

            return redirect(route('admin.meeting_management.templates.index'))->with([
                'message' => __('generic.template_delete_success'),
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());

            return redirect(route('admin.meeting_management.templates.index'))->with([
                'message' => __('generic.template_delete_failed'),
                'alert-type' => 'error',
            ]);

        }
    }

    public function getDataTable(Request $request): JsonResponse
    {
        return $this->templateService->getListDataForDatatable($request);
    }

    public function loadTemplateDetails(Request $request): JsonResponse
    {
        $data = Template::find($request->template_id);
        return response()->json([
            'success'=> true,
            'data'=> $data??'null',
        ]);

    }

}
