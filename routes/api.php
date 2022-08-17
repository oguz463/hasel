<?php

use App\Http\Controllers\Api\ImageController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('somemodel/{someModel}/images', [ImageController::class, 'index']);
Route::post('somemodel/{someModel}/images', [ImageController::class, 'store']);
Route::put('somemodel/{someModel}/images', [ImageController::class, 'update']);
Route::delete('somemodel/{someModel}/images/{index}', [ImageController::class, 'destroy']);
