<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\MeasurementUnit;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::first();
        $beefIngredient = Ingredient::where("name", "Beef")->first();
        $cheeseIngredient = Ingredient::where("name", "Cheese")->first();
        $onionIngredient = Ingredient::where("name", "Onion")->first();
        
        $gramUnit = MeasurementUnit::where("abbreviation", "g")->first();
        ProductIngredient::insert([
            // - 150g Beef
            [
                "amount_in_grams" => 150,
                "product_id" => $product->id,
                "ingredient_id" => $beefIngredient->id,
                "measurement_unit_id" => $gramUnit->id,
            ],
            // - 30g Cheese
            [
                "amount_in_grams" => 30,
                "product_id" => $product->id,
                "ingredient_id" => $cheeseIngredient->id,
                "measurement_unit_id" => $gramUnit->id,
            ],
            // - 20g Onion
            [
                "amount_in_grams" => 20,
                "product_id" => $product->id,
                "ingredient_id" => $onionIngredient->id,
                "measurement_unit_id" => $gramUnit->id,
            ],
        ]);


    }
}
