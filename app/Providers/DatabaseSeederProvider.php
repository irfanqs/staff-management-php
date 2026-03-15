<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Database\Seeders\DatabaseSeeder;

class DatabaseSeederProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Cek apakah database sudah di-seed
        // Kalau table pangkat kosong, berarti belum di-seed
        if (DB::table('pangkat')->count() === 0) {
            $this->command->call('db:seed', ['--class' => DatabaseSeeder::class]);
        }
    }
}
