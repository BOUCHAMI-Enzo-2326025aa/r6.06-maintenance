<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEpreuveRequest;
use App\Http\Requests\UpdateEpreuveRequest;
use App\Models\Epreuve;
use App\Models\EpreuveRegistrationMode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

final class EpreuveController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Epreuve::query()->with(['competition', 'registrationModes']);

        if ($competitionId = $request->query('competition_id')) {
            $query->where('competition_id', (int)$competitionId);
        }

        return response()->json($query->orderBy('name')->get());
    }

    public function store(StoreEpreuveRequest $request): JsonResponse
    {
        $data = $request->validated();
        $modes = $data['modes'] ?? null;
        unset($data['modes']);

        $epreuve = DB::transaction(function () use ($data, $modes) {
            $epreuve = Epreuve::query()->create($data);

            if (is_array($modes)) {
                foreach (array_values(array_unique($modes)) as $mode) {
                    EpreuveRegistrationMode::query()->create([
                        'epreuve_id' => $epreuve->id,
                        'mode' => $mode,
                    ]);
                }
            }

            return $epreuve;
        });

        return response()->json($epreuve->load(['competition', 'registrationModes']), 201);
    }

    public function show(Epreuve $epreuve): JsonResponse
    {
        return response()->json($epreuve->load(['competition', 'registrationModes']));
    }

    public function update(UpdateEpreuveRequest $request, Epreuve $epreuve): JsonResponse
    {
        $data = $request->validated();
        $modes = $data['modes'] ?? null;
        unset($data['modes']);

        DB::transaction(function () use ($epreuve, $data, $modes) {
            if ($data !== []) {
                $epreuve->fill($data);
                $epreuve->save();
            }

            if (is_array($modes)) {
                $uniqueModes = array_values(array_unique($modes));

                $epreuve->registrationModes()
                    ->whereNotIn('mode', $uniqueModes)
                    ->delete();

                $now = now();

                foreach ($uniqueModes as $mode) {
                    // Insert idempotent et explicite (évite les surprises Eloquent selon driver)
                    DB::table('epreuve_registration_modes')->insertOrIgnore([
                        'epreuve_id' => $epreuve->id,
                        'mode' => $mode,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        });

        return response()->json($epreuve->refresh()->load(['competition', 'registrationModes']));
    }

    public function destroy(Epreuve $epreuve): JsonResponse
    {
        $epreuve->delete();

        return response()->json(null, 204);
    }
}
