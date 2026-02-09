<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

final class FormRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_routes_for_sport_and_championnat_creation_forms(): void
    {
        // Sports list empty
        $this->getJson('/api/v1/sports')
            ->assertOk()
            ->assertExactJson([]);

        // Create sport
        $sport = $this->postJson('/api/v1/sports', ['name' => 'Triathlon'])
            ->assertCreated()
            ->json();

        // Create championnat
        $champ = $this->postJson('/api/v1/championnats', [
            'sport_id' => $sport['id'],
            'name' => 'Triathlon',
        ])
            ->assertCreated()
            ->json();

        // Options endpoint for selects
        $this->getJson('/api/v1/options/sports-championnats')
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) => $json
                ->has('sports', 1)
                ->has('championnats', 1)
                ->where('sports.0.id', $sport['id'])
                ->where('championnats.0.id', $champ['id'])
                ->etc()
            );
    }
}
