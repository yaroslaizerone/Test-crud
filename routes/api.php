<?php

use App\Http\Controllers\Api\DeskController;
use App\Http\Controllers\Api\DeskListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResources([
    'desks' => DeskController::class,
    'desklists' => DeskListController::class,
]);



