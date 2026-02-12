<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompetitionRequest;
use App\Http\Requests\UpdateCompetitionRequest;
use App\Models\Competition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CompetitionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Competition::query()->with('championnat');

        if ($championnatId = $request->query('championnat_id')) {
            $query->where('championnat_id', (int)$championnatId);
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(StoreCompetitionRequest $request): JsonResponse
    {
        $competition = Competition::query()->create($request->validated());

        return response()->json($competition->load('championnat'), 201);
    }

    public function show(Competition $competition): JsonResponse
    {
        return response()->json($competition->load(['championnat', 'epreuves.registrationModes']));
    }

    public function update(UpdateCompetitionRequest $request, Competition $competition): JsonResponse
    {
        $competition->fill($request->validated());
        $competition->save();

        return response()->json($competition->load('championnat'));
    }

    public function destroy(Competition $competition): JsonResponse
    {
        $competition->delete();

        return response()->json(null, 204);
    }
}
