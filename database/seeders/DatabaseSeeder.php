<?php

namespace Database\Seeders;

use App\Infrastructure\Laravel\Models\AgencyModel;
use App\Infrastructure\Laravel\Models\SpyModel;
use App\Infrastructure\Laravel\Models\UserModel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserModel::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        AgencyModel::factory(5)->create();
        SpyModel::factory(20)->create();
    }
}
