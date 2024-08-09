<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\PersonalInfoController;

Route::post('/submit-form', [PersonalInfoController::class, 'store']);
