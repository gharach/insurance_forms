<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalInfoController;

// Define the route for storing personal information
Route::post('/personal-info', [PersonalInfoController::class, 'store']);
