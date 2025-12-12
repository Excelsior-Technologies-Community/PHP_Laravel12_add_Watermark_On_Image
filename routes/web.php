<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

// Show the image upload page
Route::get('image-upload', [ImageController::class, 'index']);

// Handle the upload + watermark logic
Route::post('image-upload', [ImageController::class, 'store'])->name('image.store');
