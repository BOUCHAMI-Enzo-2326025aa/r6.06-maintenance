<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

enum InscriptionType: string
{
    case Individuel = 'individuel';
    case Relais = 'relais';
}
