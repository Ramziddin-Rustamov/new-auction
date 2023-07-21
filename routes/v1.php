<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\v1\AuthController;
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

Route::middleware(['auth:jwt','verified'])->group(function () {
        Route::resource('bidding-history',BiddingHistoryController::class);
        Route::resource('product',ProductController::class);
        Route::resource('currentBid',CurrentBidController::class);
        Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
    });
});
    