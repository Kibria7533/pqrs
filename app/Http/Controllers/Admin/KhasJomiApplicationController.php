<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\KhasJomiApplication;
use App\Models\LocDivision;
use App\Models\LocUnion;
use App\Models\User;
use App\Models\UserType;
use App\Services\KhasJomiApplicationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class KhasJomiApplicationController extends BaseController
{
    protected KhasJomiApplicationService $khasJomiApplicationService;

    public function __construct(KhasJomiApplicationService $khasJomiApplicationService)
    {
        $this->khasJomiApplicationService = $khasJomiApplicationService;
        $this->authorizeResource(KhasJomiApplication::class);
    }


    /**
     * @return View
     */
    public function index(): View
    {
        dd('index');

    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('backend.khas-jomi-applications.edit-add');

    }


    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->userService->validator($request)->validate();

        try {
            $this->userService->createUser($validatedData);
        } catch (\Throwable $exception) {
            Log::debug($exception->getMessage());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }


        return redirect()->route('admin.users.index')->with([
            'message' => __('generic.object_created_successfully', ['object' => 'User']),
            'alert-type' => 'success'
        ]);
    }

    /**
     * @param User $user
     * @param Request $request
     * @return View
     */
    public function show(User $user, Request $request): View
    {
        return \view(self::VIEW_PATH . 'read', compact('user'));
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $userTypes = UserType::authUserWiseType()->get();

        return \view(self::VIEW_PATH . 'edit-add', compact('user', 'userTypes'));
    }

    /**
     * @param User $user
     * @param Request $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(User $user, Request $request): RedirectResponse
    {
        $validatedData = $this->userService->validator($request, $user->id)->validate();

        DB::beginTransaction();
        try {
            $this->userService->updateUser($user, $validatedData);
            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            Log::debug($exception->getMessage());
            Log::debug($exception->getTraceAsString());
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return redirect()->route('admin.users.index')->with([
            'message' => __('generic.object_updated_successfully', ['object' => 'User']),
            'alert-type' => 'success'
        ]);

    }

    /**
     *  Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $this->userService->deleteUser($user);
        } catch (\Exception $exception) {
            return back()->with([
                'message' => __('generic.something_wrong_try_again'),
                'alert-type' => 'error'
            ]);
        }

        return back()->with([
            'message' => __('generic.object_deleted_successfully', ['object' => 'User']),
            'alert-type' => 'success'
        ]);
    }

    public function createJamabandi(): View
    {
        return \view('backend.jamabandi.edit-add');
    }

    public function createKabuliat(): View
    {
        return \view('backend.kabuliat.edit-add');
    }

}
