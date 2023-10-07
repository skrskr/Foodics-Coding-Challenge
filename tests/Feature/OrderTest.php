<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\MeasurementUnit;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    private MeasurementUnit $unit;
    private Product $product;


    protected function setUp(): void
    {
        parent::setUp();

        $this->unit = $this->createMeasurementUnit();
        $this->product = $this->createProduct();
    }

    /**
     * A Test order created succssfully
     */
    public function test_order_stored_successfully(): void
    {
        $ingredientIds = $this->createIngredients(ingredintsStockCapcity: [500, 1000, 1500]);

        $this->createProductIngredients(ingredientIds: $ingredientIds, productIngredientAmounts: [50, 400, 500]);
        

        $response = $this->post('/api/v1/orders', [
            "products" => [
                [
                    "product_id" => $this->product->id,
                    "quantity" => 1
                ],
            ]
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Order::count());
    }

    /**
     * A Test order created succssfully
     */
    public function test_ingredient_stock_updated_successfully(): void
    {
        $ingredientIds = $this->createIngredients(ingredintsStockCapcity: [500, 1000, 1500]);

        $this->createProductIngredients(ingredientIds: $ingredientIds, productIngredientAmounts: [50, 400, 500]);
        
        $ingredientExpectedQuantities = [450, 600, 1000];

        
        $response = $this->post('/api/v1/orders', [
            "products" => [
                [
                    "product_id" => $this->product->id,
                    "quantity" => 1
                ],
            ]
        ]);

        $response->assertStatus(201);
        $this->assertEquals(1, Order::count());
        
        $ingredients = Ingredient::whereIn("id", $ingredientIds)->get();

        foreach($ingredients as $index => $ingredient) {
            $this->assertEquals($ingredientExpectedQuantities[$index], $ingredient->available_quantity_in_grams);
        }
    }

    private function createMeasurementUnit(): MeasurementUnit
    {
        return MeasurementUnit::factory()->create();
    }

    private function createProduct(): Product
    {
        return Product::factory()->create();
    }

    private function createIngredients(array $ingredintsStockCapcity): array
    {
        $ingredientIds = [];
        for($i = 0; $i < count($ingredintsStockCapcity); $i++) {
            $ingredient = Ingredient::factory()->create([
                'measurement_unit_id' => $this->unit->id,
                'stock_capacity_in_grams' => $ingredintsStockCapcity[$i],
                'available_quantity_in_grams' => $ingredintsStockCapcity[$i],
            ]);
            array_push($ingredientIds, $ingredient->id);
        }
        return $ingredientIds;
    }

    private function createProductIngredients(array $ingredientIds, array $productIngredientAmounts): void
    {
        foreach($ingredientIds as $index => $ingredientId) {
            ProductIngredient::factory()->create([
                'product_id' => $this->product->id,
                'ingredient_id' => $ingredientId,
                'measurement_unit_id' => $this->unit->id,
                'amount_in_grams' =>$productIngredientAmounts[$index]
            ]);
        }
    }
}
