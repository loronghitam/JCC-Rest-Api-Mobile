<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\UserController;
// use App\Http\Controllers\AddressController;
// use App\Http\Controllers\ProductController;
// use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* -------------------------------------------------------------------------- */
/*                                PUBLIC ROUTE                                */
/* -------------------------------------------------------------------------- */
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
/* -------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------- */
/*                               PROTECTED ROUTE                              */
/* -------------------------------------------------------------------------- */
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('user', UserController::class);
    Route::resource('address', AddressController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
    Route::resource('cart', CartController::class);
    Route::resource('chat', ChatController::class);
});
/* -------------------------------------------------------------------------- */
