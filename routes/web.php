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
Route::post('/update-quantity/{id}', [BuyController::class, 'update_quantity'])->name('cart.update_quantity')->middleware(['auth', 'verified']);
Route::get('/xoasptronggio/{id}', [BuyController::class,'xoasptronggio'])->name('cart.remove')->middleware(['auth', 'verified']);
Route::get('/xoatatca', [BuyController::class,'xoatatca'])->name('cart.remove_all')->middleware(['auth', 'verified']);
//Route trang thanh toán
Route::match(['get', 'post'], '/thanh-toan', [BuyController::class, 'checkout_page'])->name('checkout.checkout_page');
// Route::post('/change-address', [BuyController::class, 'change_address'])->name('cart.change_address')->middleware(['auth', 'verified']);
Route::post('/thanh-toan/change-address', [BuyController::class, 'change_address'])->name('checkout.change_address');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
