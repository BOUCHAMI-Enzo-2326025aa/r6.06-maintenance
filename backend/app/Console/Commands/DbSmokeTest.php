<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

final class DbSmokeTest extends Command
{
    protected $signature = 'db:smoke-test';

    protected $description = 'Vérifie rapidement la connexion BD et l’accès en lecture/écriture.';

    public function handle(): int
    {
        $connection = DB::connection();

        $this->info('Driver   : ' . $connection->getDriverName());
        $this->info('Database : ' . (string)$connection->getDatabaseName());

        $selectOne = $connection->selectOne('SELECT 1 AS ok');
        $this->info('SELECT 1 : ' . json_encode($selectOne));

        try {
            $exists = $connection->getSchemaBuilder()->hasTable('migrations');
            if (!$exists) {
                $this->warn("Table 'migrations' absente : lance d'abord 'php artisan migrate'.");
            } else {
                $count = (int)$connection->table('migrations')->count();
                $this->info('migrations rows: ' . $count);
            }
        } catch (\Throwable $e) {
            $this->warn('Impossible de vérifier la table migrations.');
            $this->warn($e->getMessage());
        }

        $this->info('OK');

        return self::SUCCESS;
    }
}
