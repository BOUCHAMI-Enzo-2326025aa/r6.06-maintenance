<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSportRequest;
use App\Http\Requests\UpdateSportRequest;
use App\Models\Sport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SportController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Sport::query();

        if ($name = $request->query('name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(StoreSportRequest $request): JsonResponse
    {
        $sport = Sport::query()->create($request->validated());

        return response()->json($sport, 201);
    }

    public function show(Sport $sport): JsonResponse
    {
        return response()->json($sport->load('championnats'));
    }

    public function update(UpdateSportRequest $request, Sport $sport): JsonResponse
    {
        $sport->fill($request->validated());
        $sport->save();

        return response()->json($sport);
    }

    public function destroy(Sport $sport): JsonResponse
    {
        $sport->delete();

        return response()->json(null, 204);
    }
}
