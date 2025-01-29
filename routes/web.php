<?php

use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\VerificationApiController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\IndexControler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexControler::class,'index'])->name("index");
Route::get('email/verify/{id}', [VerificationApiController::class , 'verify'])->name('verificationapi.verify');
Route::get('email/resend', [VerificationApiController::class , 'resend'])->name('verificationapi.resend');

Auth::routes([
    'verify'=>true
]);
Route::middleware(['auth'])->group(function () {
Route::post("/post-bidmargin", [DetailsController::class, 'addBidmargin'])->name("addBidmargin");
Route::get("/view/{id}", [DetailsController::class, 'view'])->name("view");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');


//   for test case 
Route::get('/product/{id}', [DetailsController::class, 'view'])->name('product.details');
Route::post('/product/add-bid-margin', [DetailsController::class, 'addBidmargin'])->name('product.addBidMargin');

});