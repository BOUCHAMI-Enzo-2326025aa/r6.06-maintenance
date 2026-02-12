<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class SportSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_sport_championnat_competition_epreuve_and_enforces_uniques(): void
    {
        $sportId = DB::table('sports')->insertGetId([
            'name' => 'Sports d\'hiver',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $championnatId = DB::table('championnats')->insertGetId([
            'sport_id' => $sportId,
            'name' => 'JO hiver',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $competitionId = DB::table('competitions')->insertGetId([
            'championnat_id' => $championnatId,
            'name' => 'Biathlon',
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $epreuveId = DB::table('epreuves')->insertGetId([
            'competition_id' => $competitionId,
            'name' => 'Ski de fond',
            'min_team_size' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('epreuve_registration_modes')->insert([
            'epreuve_id' => $epreuveId,
            'mode' => 'individual',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('epreuve_registration_modes')->insert([
            'epreuve_id' => $epreuveId,
            'mode' => 'team',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // même mode une deuxième fois => unique(epreuve_id, mode)
        DB::table('epreuve_registration_modes')->insert([
            'epreuve_id' => $epreuveId,
            'mode' => 'team',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
