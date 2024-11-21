<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Database\Factories;

use App\Infrastructure\Laravel\Models\AgencyModel;
use App\Infrastructure\Laravel\Models\SpyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<SpyModel>
 */
class SpyModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<SpyModel>
     */
    protected $model = SpyModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthDate = fake()->date();

        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'agency_id' => AgencyModel::inRandomOrder()->first()->id ?? AgencyModel::factory()->create()->id,
            'country_of_operation' => fake()->country(),
            'date_of_birth' => $birthDate,
            'date_of_death' => fake()->boolean() ? fake()->dateTimeBetween($birthDate) : null,
        ];
    }
}
