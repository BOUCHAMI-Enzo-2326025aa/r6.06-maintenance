<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final readonly class Sport
{
    public function __construct(
        public int  $id,
        public Name $name,
    )
    {
    }
}
