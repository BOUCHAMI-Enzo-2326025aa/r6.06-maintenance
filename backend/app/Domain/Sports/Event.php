<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final readonly class Event
{
    public function __construct(
        public int  $id,
        public Name $name,
        public ?int $order = null,
    )
    {
    }
}
