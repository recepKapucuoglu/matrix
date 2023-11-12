<?php

use App\Http\Controllers\MatrixController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'layout'], function(){
    Route::post('/create', [MatrixController::class, 'createLayout']);
    Route::get('/getall', [MatrixController::class, 'getAllListLayout']);
    Route::post('/get-value', [MatrixController::class, 'getLayoutValue']);
});


