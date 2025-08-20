<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password-change', [ProfileController::class, 'passwordChange'])->name('password_change');
    Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('profilepasswordUpadte');

   Route::get('category', [CategoryController::class, 'index'])->name('category.index');
   Route::post('category-store', [CategoryController::class, 'store'])->name('category.store');
   Route::get('category/edit/{slug}', [CategoryController::class, 'edit'])->name('category.edit');
   Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');
   Route::delete('category/delete/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');
   Route::post('/category/status-update', [CategoryController::class, 'statusUpdate'])
     ->name('category.status.update');
     // brand
     Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
Route::post('/brands/store', [BrandController::class, 'store'])->name('brands.store');
Route::get('/brands/edit/{id}', [BrandController::class, 'edit'])->name('brands.edit');
Route::post('/brands/update/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/delete/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
Route::post('/brands/status-update', [BrandController::class, 'statusUpdate'])->name('brands.status.update');

});

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
   Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
