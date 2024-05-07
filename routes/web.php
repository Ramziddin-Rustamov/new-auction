<?php

use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\ComplitedProductsController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\IndexControler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexControler::class,'index'])->name("index");

Auth::routes();
Route::middleware(['auth'])->group(function () {
Route::post("/post-bidmargin", [DetailsController::class, 'addBidmargin'])->name("addBidmargin");
Route::get("/view/{id}", [DetailsController::class, 'view'])->name("view");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
});