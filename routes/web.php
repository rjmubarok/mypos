<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\InstituteController;
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
    Route::resource('users', UsersController::class);
    Route::get('/user/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('user.edit');
    Route::patch('/users/{id}', [UsersController::class, 'Userupdate'])->name('user_update');
    Route::post('users/status-update', [App\Http\Controllers\UsersController::class, 'statusUpdate'])->name('users.statusUpdate');
    Route::get('/institute', [App\Http\Controllers\InstituteController::class, 'index'])->name('institute');
    Route::PUT('/institute-update', [App\Http\Controllers\InstituteController::class, 'update'])->name('institute.update');

    Route::resource('roles', RolesController::class);
    Route::resource('permissions', PermissionsController::class);
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
    Route::resource('supplier', SupplierController::class);
    Route::post('/supplier/status-update', [SupplierController::class, 'statusUpdate'])->name('supplier.status.update');
    Route::resource('product', ProductController::class);
    Route::get('products/pdf', [ProductController::class, 'generateProductPDF'])->name('products.pdf');
    Route::get('products/stock', [ProductController::class, 'Productstock'])->name('products.stock');
    Route::post('fetch/product', [ProductController::class, 'fetchProduct'])->name('fetch_product');
    Route::post('stock/update', [ProductController::class, 'updateStock'])->name('products.stock.update');
    Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('products.lowStock');

    Route::post('/product/status-update', [ProductController::class, 'statusUpdate'])->name('product.status.update');
    Route::get('multiple/product/add', [ProductController::class, 'MultiProductAdd'])->name('multiproduct.add');
    Route::post('multiple/product/store', [ProductController::class, 'storeMultiple'])->name('product.storeMultiple');
    Route::POST('/cat_product', [SaleController::class, 'fetchProductBycat'])->name('fetch_product_by_category');
    Route::resource('sale', SaleController::class);
    Route::get('sale-invoice/{id}', [SaleController::class, 'downloadInvoice'])->name('sale.invoice');
    Route::get('due-sales', [SaleController::class, 'dueSales'])->name('salesdue.list');
    Route::post('/sale/{sale}/update-due', [SaleController::class, 'updateDue'])->name('sale.updateDue');

    Route::get('sales-report', [App\Http\Controllers\SaleController::class, 'SelseReport'])->name('sales.report');
    Route::post('sales-report/datewise', [App\Http\Controllers\SaleController::class, 'datewiseReport'])->name('sales.report.datewise');
    Route::post('sales-report/customerwise', [App\Http\Controllers\SaleController::class, 'customerwiseReport'])->name('sales.report.customerwise');

    // PDF download
    Route::get('sales-report/pdf/all', [App\Http\Controllers\SaleController::class, 'allSalesPDF'])->name('sales.report.pdf.all');
    Route::get('sales-report/pdf/datewise', [App\Http\Controllers\SaleController::class, 'datewisePDF'])->name('sales.report.pdf.datewise');
    Route::get('sales-report/pdf/customerwise', [App\Http\Controllers\SaleController::class, 'customerwisePDF'])->name('sales.report.pdf.customerwise');

    Route::resource('customer', CustomerController::class);
});

// User routes
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
