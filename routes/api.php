<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::get('groups', [CommonController::class, 'groups']);
    Route::get('agents', [CommonController::class, 'agents']);
    Route::get('agent', [CommonController::class, 'agent']);
    Route::get('schemes', [CommonController::class, 'schemes']);
    Route::get('tickets', [CommonController::class, 'tickets']);
    Route::get('rates', [CommonController::class, 'rates']);
    Route::get('add', [CommonController::class, 'add']);
    Route::put('rates/{rate}', [CommonController::class, 'updateAgentRate']);
    Route::get('prices', [CommonController::class, 'prices']);
    Route::post('save-number', [CommonController::class, 'saveNumber']);
    Route::post('update-number', [CommonController::class, 'updateNumber']);
    Route::delete('delete-number', [CommonController::class, 'deleteNumber']);
    Route::delete('delete-bill', [CommonController::class, 'deleteBill']);
    Route::get('bill-details', [CommonController::class, 'billDetails']);


    Route::post('/create-agent', [AuthController::class, 'createAgent']);
    Route::post('/update-agent', [AuthController::class, 'updateAgent']);
    Route::put('/change-login-status', [AuthController::class, 'changeLoginStatus']);
    Route::put('/change-sale-status', [AuthController::class, 'changeSaleStatus']);



    Route::post('logout', [AuthController::class, 'logout']);
});


