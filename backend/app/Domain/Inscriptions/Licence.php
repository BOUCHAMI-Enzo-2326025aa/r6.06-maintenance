<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

final readonly class Licence
{
    public function __construct(
        public int $number,
        public bool $validated,
        public string $category,
    ) {
    }
}
