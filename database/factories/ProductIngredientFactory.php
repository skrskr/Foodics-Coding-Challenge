<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\MeasurementUnit;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingredient>
 */
class ProductIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount_in_grams' => fake()->randomFloat(2, 10, 100),
            'measurement_unit_id' => MeasurementUnit::factory()->create(),
            'product_id' => Product::factory()->create(),
            'ingredient_id' => Ingredient::factory()->create(),
        ];
    }
}
