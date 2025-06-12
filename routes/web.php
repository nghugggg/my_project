<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BuyController;
use Illuminate\Support\Facades\Route;

//Site
Route::get('/', [SiteController::class,'index']);
Route::get('/detail/product/{id}', [SiteController::class,'chitietsp']);
Route::get('/sp_danhmuc/{id}', [SiteController::class,'sptheodm'])->middleware(['auth', 'verified']);
Route::get('/logoutt', [SiteController::class, 'logout']);
//Route cart
Route::get('/hiengiohang', [BuyController::class,'hiengiohang'])->name('cart.gio_hang')->middleware(['auth', 'verified']);
Route::post('/hiengiohang', [BuyController::class,'hiengiohang'])->name('cart.gio_hang')->middleware(['auth', 'verified']);
Route::post('/themvaogio/{id}/{soluong?}', [BuyController::class,'themvaogio'])->name('cart.add_cart')->middleware(['auth', 'verified']);

Route::get('/xoasptronggio/{id}', [SiteController::class,'xoasptronggio'])->middleware(['auth', 'verified']);
Route::get('/xoatatca', [SiteController::class,'xoatatca'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
