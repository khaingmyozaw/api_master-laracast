<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);//->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);//->middleware('auth:sanctum');

// Route::apiResource('/tickets', TicketController::class);