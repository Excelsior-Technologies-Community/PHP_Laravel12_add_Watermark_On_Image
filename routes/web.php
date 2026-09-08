<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;


/*
|--------------------------------------------------------------------------
| Image Watermark Routes
|--------------------------------------------------------------------------
*/


// Image upload page + gallery + search + filter + sorting
Route::get(
    '/image-upload',
    [ImageController::class, 'index']
)->name('image.upload');


// Process image + watermark
Route::post(
    '/image-upload',
    [ImageController::class, 'store']
)->name('image.store');


// Download processed image
Route::get(
    '/image-download/{filename}',
    [ImageController::class, 'download']
)->name('image.download');


// Delete processed image
Route::delete(
    '/image-delete/{filename}',
    [ImageController::class, 'destroy']
)->name('image.destroy');
