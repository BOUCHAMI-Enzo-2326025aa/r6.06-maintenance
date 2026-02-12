<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sports', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('championnats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sport_id')->constrained('sports')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->timestamps();

            $table->unique(['sport_id', 'name']);
        });

        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('championnat_id')->constrained('championnats')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('status', 20)->default('draft');
            $table->timestamps();

            $table->unique(['championnat_id', 'name']);
            $table->index(['championnat_id', 'status']);
        });

        Schema::create('epreuves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained('competitions')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedSmallInteger('min_team_size')->default(2);
            $table->timestamps();

            $table->unique(['competition_id', 'name']);
        });

        // Multi-autorisation : une épreuve peut accepter plusieurs modes d'inscription.
        Schema::create('epreuve_registration_modes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('epreuve_id')->constrained('epreuves')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('mode', 20);
            $table->timestamps();

            $table->unique(['epreuve_id', 'mode']);
            $table->index(['mode']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('epreuve_registration_modes');
        Schema::dropIfExists('epreuves');
        Schema::dropIfExists('competitions');
        Schema::dropIfExists('championnats');
        Schema::dropIfExists('sports');
    }
};
