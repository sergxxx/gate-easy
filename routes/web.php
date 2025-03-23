<?php

use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('gates');
})->name('gates');*/

Route::get('/{any}', function () {
    return view('gates');
})->where('any', '.*');
