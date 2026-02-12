<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChampionnatRequest;
use App\Http\Requests\UpdateChampionnatRequest;
use App\Models\Championnat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ChampionnatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Championnat::query()->with('sport')->withCount('competitions');

        if ($sportId = $request->query('sport_id')) {
            $query->where('sport_id', (int)$sportId);
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(StoreChampionnatRequest $request): JsonResponse
    {
        $championnat = Championnat::query()->create($request->validated());

        return response()->json($championnat->load('sport'), 201);
    }

    public function show(Championnat $championnat): JsonResponse
    {
        return response()->json($championnat->load(['sport', 'competitions.epreuves.registrationModes']));
    }

    public function update(UpdateChampionnatRequest $request, Championnat $championnat): JsonResponse
    {
        $championnat->fill($request->validated());
        $championnat->save();

        return response()->json($championnat->load('sport'));
    }

    public function destroy(Championnat $championnat): JsonResponse
    {
        $championnat->delete();

        return response()->json(null, 204);
    }
}
