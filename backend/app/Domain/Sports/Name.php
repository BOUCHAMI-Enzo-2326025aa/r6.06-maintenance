<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final readonly class Name
{
    public string $value;

    public function __construct(string $value, string $entityLabel = 'Entité')
    {
        $normalized = trim($value);
        if ($normalized === '') {
            throw InvalidName::empty($entityLabel);
        }

        $this->value = $normalized;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
