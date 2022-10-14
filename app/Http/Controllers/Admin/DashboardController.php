<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Classes\AuthHelper;
use App\Http\Controllers\BaseController;
use App\Models\LandlessUser;
use App\Models\Office;
use Illuminate\Contracts\View\View;
use Modules\Khotian\App\Models\EightRegister;
use Modules\Landless\App\Models\Landless;

class DashboardController extends BaseController
{
    /**
     * @return View
     */
    public function dashboard(): View
    {

        $authUser = AuthHelper::getAuthUser();
        $office = Office::getUserOffice();

        $applications = new Landless;
        $totalApplication = $applications->get();



        return view('dashboard.index', compact('totalApplication'));
    }

}
