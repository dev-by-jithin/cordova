<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('groups', [CommonController::class, 'groups']);
    Route::get('agents', [CommonController::class, 'agents']);
    Route::get('schemes', [CommonController::class, 'schemes']);
    Route::get('tickets', [CommonController::class, 'tickets']);
    Route::get('rates', [CommonController::class, 'rates']);


    Route::post('/create-agent', [AuthController::class, 'createAgent']);



    Route::post('logout', [AuthController::class, 'logout']);
});


