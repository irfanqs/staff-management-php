<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\DatabaseSeeder;

class SeedDatabase extends Command
{
    protected $signature = 'db:seed-once';
    protected $description = 'Seed database only if not already seeded';

    public function handle(): void
    {
        // Cek apakah sudah di-seed
        if (\DB::table('pangkat')->count() > 0) {
            $this->info('Database sudah di-seed sebelumnya. Skip.');
            return;
        }

        $this->info('Seeding database...');
        $this->call('db:seed', ['--class' => DatabaseSeeder::class]);
        $this->info('Seeding selesai!');
    }
}
