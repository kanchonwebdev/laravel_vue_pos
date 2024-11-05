<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /* product controller */
    Route::get('/product/index', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/add', [ProductController::class, 'add'])->name('product.add');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::get('/product/view/{id}', [ProductController::class, 'view'])->name('product.view');
    Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/destroy/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

    /* stock route */
    Route::get('/stock/index', [ProductController::class, 'stock'])->name('stock.index');

    /* invoice controller */
    Route::get('/invoice/index', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/invoice/view/{id}', [InvoiceController::class, 'view'])->name('invoice.view');

    /* sales route */
    Route::get('/sale/index', [InvoiceController::class, 'sale'])->name('sale.index');
});

/* api route for vue frontend */
Route::get('/product/productlist', [ProductController::class, 'productlist'])->name('product.productlist');
Route::post('/invoice/store', [InvoiceController::class, 'store'])->name('invoice.store');


require __DIR__.'/auth.php';
