<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/websites/subscribe/{websiteId}', [ApiController::class, 'subscribe']);
Route::post('/websites/posts/{websiteId}', [ApiController::class, 'createPost']);
