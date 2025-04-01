<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('area_restrita')-> group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/banners', [App\Http\Controllers\BannerController::class, 'index'])->name('banners.index');
    Route::get('/banners/create', [App\Http\Controllers\BannerController::class, 'create'])->name('banners.create');
    Route::post('/banners', [App\Http\Controllers\BannerController::class, 'store'])->name('banners.store');
    Route::get('/banners/{banner}', [App\Http\Controllers\BannerController::class, 'show'])->name('banners.show');    
    Route::get('/banners/{banner}/edit', [App\Http\Controllers\BannerController::class, 'edit'])->name('banners.edit');
    Route::put('/banners/{banner}', [App\Http\Controllers\BannerController::class, 'update'])->name('banners.update');    
    Route::delete('/banners/{banner}', [App\Http\Controllers\BannerController::class, 'destroy'])->name('banners.destroy'); 
    Route::post('/banners/set_ativo/{id}', [App\Http\Controllers\BannerController::class, 'set_ativo'])->name('banners.set_ativo');

});

require __DIR__.'/auth.php';
