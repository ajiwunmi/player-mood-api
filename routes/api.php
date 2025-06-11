<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoodController;


Route::prefix('v1')
    ->middleware(['api'])
    ->group(function () {
        // Player submits mood
        Route::post('/moods', [MoodController::class, 'store']);

        // Coach views mood summary
        Route::get('/moods', [MoodController::class, 'summary']);

        // Optional: Player view page or test endpoint
        Route::get('/player', [MoodController::class, 'player']);
    });
