<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class SportApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_crud_sport_championnat_competition_epreuve_with_modes(): void
    {
        // Create sport
        $sport = $this->postJson('/api/v1/sports', ['name' => 'Triathlon'])
            ->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->whereType('id', 'integer')
                ->where('name', 'Triathlon')
                ->etc()
            )
            ->json();

        // Create championnat
        $champ = $this->postJson('/api/v1/championnats', [
            'sport_id' => $sport['id'],
            'name' => 'Triathlon',
        ])
            ->assertCreated()
            ->json();

        // Create competition
        $comp = $this->postJson('/api/v1/competitions', [
            'championnat_id' => $champ['id'],
            'name' => 'District',
            'status' => 'open',
        ])
            ->assertCreated()
            ->json();

        // Create epreuve with multiple modes
        $epreuve = $this->postJson('/api/v1/epreuves', [
            'competition_id' => $comp['id'],
            'name' => 'Nage',
            'min_team_size' => 2,
            'modes' => ['individual', 'team', 'team'],
        ])
            ->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('name', 'Nage')
                ->where('competition_id', $comp['id'])
                ->has('registration_modes', 2)
                ->etc()
            )
            ->json();

        // Update modes (remove team, add relay)
        $this->putJson('/api/v1/epreuves/' . $epreuve['id'], [
            'modes' => ['individual', 'relay'],
        ])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('id', $epreuve['id'])
                ->has('registration_modes', 2)
                ->etc()
            );

        // Filters
        $this->getJson('/api/v1/competitions?championnat_id=' . $champ['id'])
            ->assertOk()
            ->assertJsonCount(1);

        $this->getJson('/api/v1/epreuves?competition_id=' . $comp['id'])
            ->assertOk()
            ->assertJsonCount(1);

        // Show competition should eager-load epreuves + modes
        $this->getJson('/api/v1/competitions/' . $comp['id'])
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->where('id', $comp['id'])
                ->has('epreuves', 1)
                ->etc()
            );
    }
}
