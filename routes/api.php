<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TransactionRequestController;
use App\Http\Controllers\API\CheckTransactionController;
use App\Http\Controllers\API\CallbackController;

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


Route::apiResource('transaction', TransactionRequestController::class);
Route::apiResource('callback', CallbackController::class);
Route::apiResource('checkTransaction', CheckTransactionController::class);