<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final readonly class Championship
{
    public function __construct(
        public int  $id,
        public int  $sportId,
        public Name $name,
    )
    {
    }
}
