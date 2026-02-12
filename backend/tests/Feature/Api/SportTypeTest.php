<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SportTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_sport_with_type(): void
    {
        $res = $this->postJson('/api/v1/sports', [
            'name' => 'Triathlon',
            'type' => 'individuel_equipe',
        ]);

        $res->assertStatus(201)
            ->assertJsonPath('name', 'Triathlon')
            ->assertJsonPath('type', 'individuel_equipe');
    }

    public function test_refuses_invalid_type(): void
    {
        $res = $this->postJson('/api/v1/sports', [
            'name' => 'Natation',
            'type' => 'invalid',
        ]);

        $res->assertStatus(422);
    }
}
