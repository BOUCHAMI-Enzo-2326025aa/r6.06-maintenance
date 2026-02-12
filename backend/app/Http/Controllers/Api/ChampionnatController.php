<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChampionnatRequest;
use App\Http\Requests\UpdateChampionnatRequest;
use App\Models\Championnat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Endpoints API (v1) pour les championnats.
 */
final class ChampionnatController extends Controller
{
    /**
     * Liste les championnats.
     *
     * Query params disponibles :
     * - sport_id: int (filtrer par sport)
     *
     * @return JsonResponse Liste des championnats avec `sport` et `competitions_count`.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Championnat::query()->with('sport')->withCount('competitions');

        if ($sportId = $request->query('sport_id')) {
            $query->where('sport_id', (int)$sportId);
        }

        return response()->json($query->orderBy('name')->get());
    }

    /**
     * Crée un championnat.
     *
     * @return JsonResponse 201 + championnat créé, avec relation `sport` chargée.
     */
    public function store(StoreChampionnatRequest $request): JsonResponse
    {
        $championnat = Championnat::query()->create($request->validated());

        return response()->json($championnat->load('sport'), 201);
    }

    /**
     * Détail d'un championnat.
     *
     * Relations chargées :
     * - sport
     * - competitions.epreuves.registrationModes
     */
    public function show(Championnat $championnat): JsonResponse
    {
        return response()->json($championnat->load(['sport', 'competitions.epreuves.registrationModes']));
    }

    /**
     * Met à jour un championnat.
     */
    public function update(UpdateChampionnatRequest $request, Championnat $championnat): JsonResponse
    {
        $championnat->fill($request->validated());
        $championnat->save();

        return response()->json($championnat->load('sport'));
    }

    /**
     * Supprime un championnat.
     *
     * @return JsonResponse 204 si suppression OK.
     */
    public function destroy(Championnat $championnat): JsonResponse
    {
        $championnat->delete();

        return response()->json(null, 204);
    }
}
