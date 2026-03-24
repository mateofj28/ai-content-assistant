<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AIController;

Route::post('/process-text', [AIController::class, 'process']);