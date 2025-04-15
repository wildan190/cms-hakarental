<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MobilController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/admin/dashboard', [DashboardController::class, 'index']);


Route::middleware('auth:sanctum')->prefix('admin/blogs')->group(function () {
    Route::get('/', [BlogController::class, 'index']);
    Route::post('/', [BlogController::class, 'store']);
    Route::get('{id}', [BlogController::class, 'show']);
    Route::put('{id}', [BlogController::class, 'update']);
    Route::delete('{id}', [BlogController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('admin/mobils')->group(function () {
    Route::get('/', [MobilController::class, 'index']);
    Route::post('/', [MobilController::class, 'store']);
    Route::get('/{id}', [MobilController::class, 'show']);
    Route::put('/{id}', [MobilController::class, 'update']);
    Route::delete('/{id}', [MobilController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->prefix('admin/galleries')->group(function () {
    Route::get('/', [GalleryController::class, 'index']);
    Route::post('/', [GalleryController::class, 'store']);
    Route::get('/{id}', [GalleryController::class, 'show']);
    Route::put('/{id}', [GalleryController::class, 'update']);
    Route::delete('/{id}', [GalleryController::class, 'destroy']);
});