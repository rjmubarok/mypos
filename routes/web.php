<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
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
    Route::get('/profile', [AdminDashboardController::class, 'profile'])->name('profile');
});

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
   Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
