<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KalkulatorController;

Route::get('/', [KalkulatorController::class, 'index']);
Route::post('/convert', [KalkulatorController::class, 'convert']);

