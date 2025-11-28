<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Photo routes
    Route::resource('photos', PhotoController::class);
    Route::get('photos/{id}/image', [PhotoController::class, 'image'])->name('photos.image');
    Route::get('photos/{id}/download', [PhotoController::class, 'download'])->name('photos.download');
});

require __DIR__.'/auth.php';
