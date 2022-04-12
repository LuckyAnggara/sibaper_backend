<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\RequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/request/get',[RequestController::class,'get']);

Route::group(['middleware' =>['auth:sanctum']], function(){
    Route::get('/profile', function(Request $request)
    {
        return auth()->user();
    });
    Route::post('/request/store',[RequestController::class,'store']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::get('/request',[RequestController::class, 'all']);

});

Route::get('product',[ProductController::class, 'all']);


