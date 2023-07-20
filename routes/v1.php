<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\BiddingHistoryController;
use App\Http\Controllers\API\v1\CurrentBidController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Auth;




// Route::get('email/verify/{id}/{hash}', [VerificationController::class,'verify'])->name('verification.verify');
// Route::get('email/resend', [VerificationController::class,'resend'])->name('verification.resend');     
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});
    

Route::middleware('auth:jwt')->group(function () {
    Route::resource('bidding-history',BiddingHistoryController::class);
    Route::resource('product',ProductController::class);
    Route::resource('currentBid',CurrentBidController::class);
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});
    