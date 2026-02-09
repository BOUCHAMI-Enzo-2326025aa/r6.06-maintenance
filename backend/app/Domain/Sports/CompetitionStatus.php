<?php

declare(strict_types=1);

namespace App\Domain\Sports;

enum CompetitionStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case Closed = 'closed';
}
