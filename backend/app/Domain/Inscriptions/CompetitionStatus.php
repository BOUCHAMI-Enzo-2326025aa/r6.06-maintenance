<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

enum CompetitionStatus: string
{
    case Open = 'open';
    case Closed = 'closed';
}
