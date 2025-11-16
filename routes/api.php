<?php

use Illuminate\Support\Facades\Route;
use App\Financial\Infrastructure\Api\Rest\OrderController;
use App\Financial\Infrastructure\Api\Rest\PaymentController;

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'list']);
    Route::get('/{id}', [OrderController::class, 'findById']);
    Route::post('/', [OrderController::class, 'save']);
    Route::put('/{id}', [OrderController::class, 'update']);
    Route::delete('/{id}', [OrderController::class, 'delete']);
    Route::get('/status/{status}', [OrderController::class, 'findByStatus']);
});

Route::prefix('payments')->group(function () {
    Route::get('/', [PaymentController::class, 'list']);
    Route::get('/{id}', [PaymentController::class, 'findById']);
    Route::get('/order/{orderId}', [PaymentController::class, 'findByOrderId']);
    Route::post('/', [PaymentController::class, 'save']);
    Route::put('/{id}', [PaymentController::class, 'update']);
    Route::delete('/{id}', [PaymentController::class, 'delete']);
});
