<?php

use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/tickets', TicketController::class)->except(['update']);
    Route::put('/tickets/{ticket}', [TicketController::class, 'replace']);
    Route::patch('/tickets/{ticket}', [TicketController::class, 'update']);
    
    Route::apiResource('/users', UserController::class)->except(['update']);
    Route::put('/users/{user}', [UserController::class, 'replace']);
    Route::patch('/users/{user}', [UserController::class, 'update']);


    Route::apiResource('users.tickets', AuthorTicketController::class);

});