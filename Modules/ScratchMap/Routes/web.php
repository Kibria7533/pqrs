<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/scratch-map-management/', 'as' => 'admin.scratch-map-management.', 'middleware' => ['auth']], function () {
    Route::resources([
        'scratch-maps' => \Modules\ScratchMap\App\Http\Controllers\ScratchMapController::class,
    ]);
});
