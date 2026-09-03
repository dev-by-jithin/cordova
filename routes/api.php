<?php


use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommonController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);

Route::group(['middl
eware' => ['auth:sanctum']], function(){

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
    Route::post('save-remark', [CommonController::class, 'saveRemark']);
    Route::post('update-number', [CommonController::class, 'updateNumber']);
    Route::delete('delete-number', [CommonController::class, 'deleteNumber']);
    Route::delete('delete-bill', [CommonController::class, 'deleteBill']);
    Route::get('bill-details', [CommonController::class, 'billDetails']);
    Route::get('result', [CommonController::class, 'result']);
    Route::get('sales-summary', [CommonController::class, 'salesSummary']);
    Route::get('sales-users', [CommonController::class, 'salesUsers']);
    Route::get('sales-report', [CommonController::class, 'salesReport']);
    Route::get('winning-summary', [CommonController::class, 'winningSummary']);
    Route::get('winning-users', [CommonController::class, 'winningUsers']);
    Route::get('winning-report', [CommonController::class, 'winningReport']);
    Route::get('number-wise-report', [CommonController::class, 'numberWiseReport']);
    Route::get('number-wise-pdf', [CommonController::class, 'numberWisePdf']);
    Route::get('account-summary', [CommonController::class, 'accountSummary']);
    Route::get('net-pay', [CommonController::class, 'netPay']);

    Route::post('/create-agent', [AuthController::class, 'createAgent']);
    Route::post('/update-agent', [AuthController::class, 'updateAgent']);
    Route::put('/change-login-status', [AuthController::class, 'changeLoginStatus']);
    Route::put('/change-sale-status', [AuthController::class, 'changeSaleStatus']);



    Route::post('logout', [AuthController::class, 'logout']);
});


