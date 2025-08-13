<?php

use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/tickets', TicketController::class);
    Route::apiResource('/users', UserController::class);
    Route::apiResource('users.tickets', AuthorTicketController::class);

});