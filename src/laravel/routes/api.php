<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TreeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FileController;

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

Route::middleware(['web'])->group(function () {
    Route::get('/tree', [TreeController::class, 'index']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::patch('/update-access/{items}/{id}', [ItemController::class, 'updateAccess']);
        Route::patch('/rename/{items}/{id}', [ItemController::class, 'rename']);
        Route::patch('/files/{file}', [FileController::class, 'update'])->can('update', 'file');
        Route::post('/{items}', [ItemController::class, 'store']);
        Route::delete('/{items}/{id}', [ItemController::class, 'destroy']);
    });
});
