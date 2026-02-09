<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

final readonly class Competition
{
    public function __construct(
        public int $id,
        public CompetitionStatus $status,
        public int $maxEventsPerAthlete,
    ) {
    }

    public function isOpen(): bool
    {
        return $this->status === CompetitionStatus::Open;
    }
}
