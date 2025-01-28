<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\AuthUserInformationController;
use App\Http\Controllers\API\v1\BiddingHistoryController;
use App\Http\Controllers\API\v1\CurrentBidController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\VerificationApiController;
use Illuminate\Support\Facades\Auth;


// public routes here !

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::get('email/verify/{id}', [VerificationApiController::class , 'verify'])->name('verificationapi.verify');
Route::get('email/resend', [VerificationApiController::class , 'resend'])->name('verificationapi.resend');
// ,'verified'
Route::middleware(['auth:jwt'])->group(function () {
        Route::get('user/products',[AuthUserInformationController::class,'index'])->name('auth.user.products');
        Route::resource('bidding-history',BiddingHistoryController::class);
        Route::resource('product',ProductController::class);
        Route::resource('current-bid',CurrentBidController::class);
        Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});
