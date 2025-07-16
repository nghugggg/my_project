<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\OrderController;
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
Route::post('/thanh-toan/change-address', [BuyController::class, 'change_address'])->name('checkout.change_address');
Route::post('/add-address', [BuyController::class, 'add_address'])->name('add_address')->middleware('auth', 'verified');
//Route đặt hàng
Route::post('dat-hang', [OrderController::class, 'order'])->name('order.order')->middleware(['auth', 'verified']);
//Route tài khoản
Route::get('account-profile', [AccountController::class, 'profile_page'])->name('account.profile')->middleware('auth', 'verified');
Route::get('account-password', [AccountController::class, 'password_page'])->name('account.password_page')->middleware('auth', 'verified');
Route::post('account-change_password', [AccountController::class, 'change_password'])->name('account.change_password')->middleware('auth', 'verified');
Route::get('purchase', [AccountController::class, 'purchase_page'])->name('user.purchase')->middleware('auth', 'verified');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AccountController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AccountController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AccountController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
