<?php

use App\Http\Controllers\Api\v1\GateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
	Route::post('gate/open', [GateController::class, 'open']);
	Route::get('gates', [GateController::class, 'getGates']);
});
