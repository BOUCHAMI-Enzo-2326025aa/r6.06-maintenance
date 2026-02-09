<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChampionnatFullRequest;
use App\Models\Championnat;
use App\Models\Competition;
use App\Models\Epreuve;
use App\Models\EpreuveRegistrationMode;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

final class ChampionnatFullController extends Controller
{
    public function store(StoreChampionnatFullRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $championnat = DB::transaction(function () use ($payload) {
            $championnat = Championnat::query()->create([
                'sport_id' => $payload['sport_id'],
                'name' => $payload['name'],
                'lieu' => $payload['lieu'] ?? null,
            ]);

            foreach ($payload['competitions'] as $competitionData) {
                $competition = Competition::query()->create([
                    'championnat_id' => $championnat->id,
                    'name' => $competitionData['name'],
                    'status' => $competitionData['status'] ?? 'draft',
                ]);

                foreach ($competitionData['epreuves'] as $epreuveData) {
                    $epreuve = Epreuve::query()->create([
                        'competition_id' => $competition->id,
                        'name' => $epreuveData['name'],
                        'min_team_size' => $epreuveData['min_team_size'] ?? 2,
                    ]);

                    $modes = $epreuveData['modes'] ?? ['individual'];
                    foreach (array_values(array_unique($modes)) as $mode) {
                        EpreuveRegistrationMode::query()->create([
                            'epreuve_id' => $epreuve->id,
                            'mode' => $mode,
                        ]);
                    }
                }
            }

            return $championnat;
        });

        return response()->json($championnat->load(['sport', 'competitions.epreuves.registrationModes']), 201);
    }
}
