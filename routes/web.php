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


// Preview watermarked image
Route::post('/image-upload/preview', [ImageController::class, 'preview'])
    ->name('image.preview');

// Download processed image
Route::get(
    '/image-download/{filename}',
    [ImageController::class, 'download']
)->name('image.download');


// Delete processed image
<<<<<<< HEAD
Route::delete(
    '/image-delete/{filename}',
    [ImageController::class, 'destroy']
)->name('image.destroy');
=======
Route::delete('/image-delete/{filename}', [ImageController::class, 'destroy'])
    ->name('image.destroy');

// Send watermarked image via email
Route::post('/image-email/{filename}', [ImageController::class, 'email'])
    ->name('image.email');

// Watermark history
Route::get('/image-history', [ImageController::class, 'history'])
    ->name('image.history');

Route::delete('/image-history/{id}', [ImageController::class, 'destroyHistory'])
    ->name('image.history.destroy');
>>>>>>> 7cfbcb4d9021f9925402566329429255fb099557
