
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller as BaseController;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

Route::middleware('auth:api')->prefix('checklist')->group(function () {
    Route::get('/', [ChecklistController::class, 'index']); 
    Route::post('/', [ChecklistController::class, 'store']); 
    Route::delete('/{checklistId}', [ChecklistController::class, 'destroy']); 
    
    Route::prefix('{checklistId}/item')->group(function () {
        Route::get('/', [ChecklistItemController::class, 'index']); 
        Route::post('/', [ChecklistItemController::class, 'store']);
        Route::get('/{checklistItemId}', [ChecklistItemController::class, 'show']); 
        Route::put('/{checklistItemId}', [ChecklistItemController::class, 'updateStatus']); 
        Route::delete('/{checklistItemId}', [ChecklistItemController::class, 'destroy']); 
        Route::put('/rename/{checklistItemId}', [ChecklistItemController::class, 'rename']); 
    });
}); 
  