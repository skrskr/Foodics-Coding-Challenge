<?php

namespace Database\Factories;

use App\Models\MeasurementUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class IngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $stokInGrams = fake()->randomFloat(2, 1000, 10000);
        return [
            'name' => fake()->sentence(3),
            'stock_capacity_in_grams' => $stokInGrams,
            'available_quantity_in_grams' => $stokInGrams,
            'measurement_unit_id' => MeasurementUnit::factory()->create()
        ];
    }
}
