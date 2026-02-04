<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

final class InscriptionDenied extends DomainException
{
    public static function competitionClosed(): self
    {
        return new self('Inscription refusée : compétition fermée.');
    }

    public static function licenceNotValidated(): self
    {
        return new self('Inscription refusée : licencié non validé.');
    }

    public static function maxEventsReached(int $max): self
    {
        return new self("Inscription refusée : maximum d'épreuves atteint ($max).");
    }

    public static function categoryIncompatible(): self
    {
        return new self("Inscription refusée : catégorie incompatible avec l'épreuve.");
    }

    public static function teamSizeInvalid(int $min, int $max): self
    {
        return new self("Inscription refusée : nombre de membres invalide (attendu $min..$max).");
    }

    public static function duplicateMember(): self
    {
        return new self('Inscription refusée : doublon dans les membres.');
    }
}
