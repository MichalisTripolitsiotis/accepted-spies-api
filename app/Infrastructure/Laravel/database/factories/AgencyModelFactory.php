<?php

declare(strict_types=1);

namespace App\Infrastructure\Laravel\Database\Factories;

use App\Infrastructure\Laravel\Models\AgencyModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<AgencyModel>
 */
class AgencyModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<AgencyModel>
     */
    protected $model = AgencyModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
        ];
    }
}
