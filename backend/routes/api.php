<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('rooms', [RoomController::class, 'index']);
Route::apiResource('assets', AssetController::class);
Route::get('reports/rooms', [ReportController::class, 'rooms']);
