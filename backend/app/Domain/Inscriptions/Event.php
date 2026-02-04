<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

final readonly class Event
{
    public function __construct(
        public int $id,
        public string $compatibleCategory,
        public InscriptionType $type,
        public int $minTeamSize = 0,
        public int $maxTeamSize = 0,
    ) {
    }

    public function isTeam(): bool
    {
        return $this->type === InscriptionType::Relais;
    }
}
