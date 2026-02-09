<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final class CompetitionClosed extends DomainException
{
    public static function cannotAddEvent(): self
    {
        return new self("Compétition fermée : impossible d'ajouter une épreuve.");
    }
}
