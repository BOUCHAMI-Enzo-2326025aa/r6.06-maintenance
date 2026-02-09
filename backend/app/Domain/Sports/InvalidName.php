<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final class InvalidName extends DomainException
{
    public static function empty(string $entity): self
    {
        return new self("Nom invalide : $entity ne peut pas être vide.");
    }
}
