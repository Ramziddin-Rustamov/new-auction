<?php

use App\Http\Controllers\ComplitedProductsController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\IndexControler;
// use Egulias\EmailValidator\Result\Reason\DetailedReason;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// routes/web.php

// Route::get('/{any}', function () {
//     return view('fallback'); // Replace 'fallback' with the name of your fallback view
// })->where('any', '.*');


Route::get('/', [IndexControler::class,'index'])->name("index");

Auth::routes([
    'verify'=>true
]);
Route::get("/inactive-products", [ComplitedProductsController::class, 'getAllInactiveProducts'])->name("inactiveProducts");
Route::post("/post-bidmargin", [DetailsController::class, 'addBidmargin'])->name("addBidmargin");



Route::get("/view/{id}", [DetailsController::class, 'view'])->name("view");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
