<?php

use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TheaterController;
use App\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

// Route::get('/timeline', function () {
//     return view('timeline');
// })->name('timeline');

// Route::get('/updates', function () {
//     return view('updates');
// })->name('updates');

Route::get('/connect', function () {
    return view('connect');
})->name('connect');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/timeline', [TimelineController::class, 'timeline'])->name('timeline');

Route::get('/updates', [TheaterController::class, 'index'])->name('updates');

Route::get('/gallery', [PhotoController::class, 'gallery'])->name('gallery');
Route::post('/gallery/upload', [PhotoController::class, 'store'])->name('gallery.store');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/photos', [PhotoController::class, 'index'])->name('admin.photos.index');
    Route::patch('/admin/photos/{photo}/approve', [PhotoController::class, 'approve'])->name('admin.photos.approve');
    Route::patch('/admin/photos/{photo}/reject', [PhotoController::class, 'reject'])->name('admin.photos.reject');
    Route::delete('/admin/photos/{photo}', [PhotoController::class, 'destroy'])->name('admin.photos.destroy');

    Route::get('/admin/timeline', [TimelineController::class, 'index'])->name('admin.timeline.index');
    Route::post('/admin/timeline', [TimelineController::class, 'store'])->name('admin.timeline.store');
    Route::put('/admin/timeline/{timelineEvent}', [TimelineController::class, 'update'])->name('admin.timeline.update');
    Route::delete('/admin/timeline/{timelineEvent}', [TimelineController::class, 'destroy'])->name('admin.timeline.destroy');
});

require __DIR__.'/auth.php';
