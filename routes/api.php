<?php

use App\Category;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* -------------------------------------------------------------------------- */
/*                                PUBLIC ROUTE                                */
/* -------------------------------------------------------------------------- */
Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::prefix('p')->group(function () {
        Route::resource('product', ProductController::class)->only(['index', 'show']);
        Route::resource('category', CategoryController::class)->only(['index', 'show']);
    });
});

/* -------------------------------------------------------------------------- */

/* -------------------------------------------------------------------------- */
/*                               PROTECTED ROUTE                              */
/* -------------------------------------------------------------------------- */
Route::group(
    ['middleware' => 'auth:api',],
    function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        /* -------------------------------------------------------------------------- */
        /*                                 ISCOLECTOR                                 */
        /* -------------------------------------------------------------------------- */

        Route::group(['middleware' => ['role:collector']], function () {
            Route::resource('product', ProductController::class)->only(['index', 'show']);
            Route::resource('category', CategoryController::class)->only(['index', 'show']);
            Route::resource('transcation', TransactionController::class)->only(['index', 'show', 'store']);
        });

        /* ----------------------------- END ISCOLECTOR ----------------------------- */

        /* -------------------------------------------------------------------------- */
        /*                                  ISSENIMAN                                 */
        /* -------------------------------------------------------------------------- */
        Route::group(['middleware' => ['role:seniman']], function () {
            Route::resource('product', ProductController::class)->only(['create', 'edit', 'update', 'delete']);
        });

        /* ------------------------------ END ISSENIMAN ----------------------------- */
        Route::resource('user', UserController::class);
        Route::resource('address', AddressController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('cart', CartController::class);
        Route::resource('chat', ChatController::class);
    }
);
/* -------------------------------------------------------------------------- */
