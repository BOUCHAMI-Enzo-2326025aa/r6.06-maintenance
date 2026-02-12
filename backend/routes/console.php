<?php

use App\Console\Commands\DbSmokeTest;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Enregistrement de commandes dédiées (Laravel charge ce fichier dans le contexte du Kernel console)
$this->registerCommand(new DbSmokeTest());
