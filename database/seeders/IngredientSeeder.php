<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\MeasurementUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kilogramUnit = MeasurementUnit::where("abbreviation", "kg")->first();
        Ingredient::insert([
            // - 20kg Beef
            [
                "name" => "Beef",
                "stock_capacity_in_grams" => 20 * 1000,
                "available_quantity_in_grams" => 20 * 1000,
                "measurement_unit_id" => $kilogramUnit->id,
            ],
            // - 5kg Cheese
            [
                "name" => "Cheese",
                "stock_capacity_in_grams" => 5 * 1000,
                "available_quantity_in_grams" => 5 * 1000,
                "measurement_unit_id" => $kilogramUnit->id,
            ],
            // - 1kg Onion
            [
                "name" => "Onion",
                "stock_capacity_in_grams" => 1 * 1000,
                "available_quantity_in_grams" => 1 * 1000,
                "measurement_unit_id" => $kilogramUnit->id,
            ],
        ]);
    }
}
