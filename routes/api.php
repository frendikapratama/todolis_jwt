
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ChecklistItemController;

// Routes untuk Checklist
Route::prefix('checklist')->group(function () {
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