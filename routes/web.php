<?php

use App\Http\Controllers\API\v1\ProductController;
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
Route::middleware(['auth'])->group(function () {
Route::post("/post-bidmargin", [DetailsController::class, 'addBidmargin'])->name("addBidmargin");
Route::get("/view/{id}", [DetailsController::class, 'view'])->name("view");
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');
// Route to display product index page
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// // Route to display product creation page
// Route::get('/products/create', [ProductController::class, 'store'])->name('products.create');

// // Route to display product view page
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.view');
});