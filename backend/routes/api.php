<?php

use App\Http\Controllers\Api\ChampionnatController;
use App\Http\Controllers\Api\ChampionnatFullController;
use App\Http\Controllers\Api\CompetitionController;
use App\Http\Controllers\Api\EpreuveController;
use App\Http\Controllers\Api\SportController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Sports
    Route::get('sports', [SportController::class, 'index']);
    Route::get('sports/{sport}', [SportController::class, 'show']);
    Route::post('sports', [SportController::class, 'store']);
    Route::put('sports/{sport}', [SportController::class, 'update']);
    Route::delete('sports/{sport}', [SportController::class, 'destroy']);

    // Championnats (simple)
    Route::get('championnats', [ChampionnatController::class, 'index']);
    Route::get('championnats/{championnat}', [ChampionnatController::class, 'show']);
    Route::post('championnats', [ChampionnatController::class, 'store']);

    // Championnat complet (formulaire imbriqué)
    Route::post('championnats/full', [ChampionnatFullController::class, 'store']);

    // Competitions
    Route::get('competitions', [CompetitionController::class, 'index']);
    Route::get('competitions/{competition}', [CompetitionController::class, 'show']);
    Route::post('competitions', [CompetitionController::class, 'store']);
    Route::put('competitions/{competition}', [CompetitionController::class, 'update']);
    Route::delete('competitions/{competition}', [CompetitionController::class, 'destroy']);

    // Epreuves
    Route::get('epreuves', [EpreuveController::class, 'index']);
    Route::get('epreuves/{epreuve}', [EpreuveController::class, 'show']);
    Route::post('epreuves', [EpreuveController::class, 'store']);
    Route::put('epreuves/{epreuve}', [EpreuveController::class, 'update']);
    Route::delete('epreuves/{epreuve}', [EpreuveController::class, 'destroy']);

    // Helper pour formulaires (selects): sports + championnats
    Route::get('options/sports-championnats', function () {
        $sports = \App\Models\Sport::query()->orderBy('name')->get(['id', 'name', 'type']);
        $championnats = \App\Models\Championnat::query()->orderBy('name')->get(['id', 'sport_id', 'name', 'lieu']);

        return response()->json([
            'sports' => $sports,
            'championnats' => $championnats,
        ]);
    });
});
