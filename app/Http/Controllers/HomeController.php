<?php

namespace App\Http\Controllers;

use App\Helpers\Classes\AuthHelper;
use Illuminate\Contracts\View\View;

class HomeController extends BaseController
{
    public function __construct()
    {
        /*$this->middleware(function () {
            if (!empty(AuthHelper::getAuthUser())) {
                return redirect()->route('admin.dashboard');
            }
        });*/
    }

    /**
     * Show the application dashboard.
     * @return View
     */
    public function home()
    {
        return \view('master::landless-portal.home');
    }
}
