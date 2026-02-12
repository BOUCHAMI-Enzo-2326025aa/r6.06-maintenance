<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

final class SportSeedingTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_sport_hierarchy(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(2, DB::table('sports')->count());
        $this->assertSame(2, DB::table('championnats')->count());
        $this->assertSame(2, DB::table('competitions')->count());

        // Biathlon: 2 épreuves, Triathlon/District: 3 épreuves
        $this->assertSame(5, DB::table('epreuves')->count());

        // On met au moins 1 mode par épreuve (ici on seed seulement 'individual')
        $this->assertSame(5, DB::table('epreuve_registration_modes')->count());

        // Idempotence: relancer le seeder ne doit pas dupliquer les enregistrements
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(2, DB::table('sports')->count());
        $this->assertSame(2, DB::table('championnats')->count());
        $this->assertSame(2, DB::table('competitions')->count());
        $this->assertSame(5, DB::table('epreuves')->count());
        $this->assertSame(5, DB::table('epreuve_registration_modes')->count());
    }
}
