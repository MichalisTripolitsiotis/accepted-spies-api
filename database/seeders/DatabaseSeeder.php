<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        UserModel::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        SpyModel::factory(5)->create();
    }
}
