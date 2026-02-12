<?php

namespace Database\Seeders;

use App\Models\Championnat;
use App\Models\Competition;
use App\Models\Epreuve;
use App\Models\EpreuveRegistrationMode;
use App\Models\Sport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Exemple 1: Sports d'hiver -> JO hiver -> Biathlon -> (Ski de fond, Tir)
        $winterSport = Sport::query()->updateOrCreate(
            ['name' => "Sports d'hiver"],
            []
        );

        $joHiver = Championnat::query()->updateOrCreate(
            ['sport_id' => $winterSport->id, 'name' => 'JO hiver'],
            []
        );

        $biathlon = Competition::query()->updateOrCreate(
            ['championnat_id' => $joHiver->id, 'name' => 'Biathlon'],
            ['status' => 'open']
        );

        $skiFond = Epreuve::query()->updateOrCreate(
            ['competition_id' => $biathlon->id, 'name' => 'Ski de fond'],
            ['min_team_size' => 2]
        );

        EpreuveRegistrationMode::query()->firstOrCreate(
            ['epreuve_id' => $skiFond->id, 'mode' => 'individual'],
            []
        );

        $tir = Epreuve::query()->updateOrCreate(
            ['competition_id' => $biathlon->id, 'name' => 'Tir'],
            ['min_team_size' => 2]
        );

        EpreuveRegistrationMode::query()->firstOrCreate(
            ['epreuve_id' => $tir->id, 'mode' => 'individual'],
            []
        );

        // Exemple 2: Triathlon -> Triathlon -> District -> (Nage, Course, Vélo)
        $triathlonSport = Sport::query()->updateOrCreate(
            ['name' => 'Triathlon'],
            []
        );

        $triathlonChamp = Championnat::query()->updateOrCreate(
            ['sport_id' => $triathlonSport->id, 'name' => 'Triathlon'],
            []
        );

        $district = Competition::query()->updateOrCreate(
            ['championnat_id' => $triathlonChamp->id, 'name' => 'District'],
            ['status' => 'open']
        );

        foreach (['Nage', 'Course', 'Vélo'] as $name) {
            $epreuve = Epreuve::query()->updateOrCreate(
                ['competition_id' => $district->id, 'name' => $name],
                ['min_team_size' => 2]
            );

            EpreuveRegistrationMode::query()->firstOrCreate(
                ['epreuve_id' => $epreuve->id, 'mode' => 'individual'],
                []
            );
        }
    }
}
