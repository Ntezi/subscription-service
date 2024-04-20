<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/websites/{website}/subscribe', [ApiController::class, 'subscribe']);
Route::post('/websites/{website}/posts', [ApiController::class, 'createPost']);
