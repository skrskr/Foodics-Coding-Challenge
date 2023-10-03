<?php

namespace App\Rules;

use App\Models\Ingredient;
use App\Models\ProductIngredient;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IngredientQuantityAvailableRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach($value as $productItem) {
            $productId = $productItem['product_id'];
            $quanity = $productItem['quantity'];

            $productIngredients = ProductIngredient::where("product_id", $productId)->pluck('amount_in_grams','ingredient_id')->toArray();
         
            $ingredientIds = array_keys($productIngredients);
         
            $ingredients = Ingredient::whereIn("id", $ingredientIds)->get(['id', 'available_quantity_in_grams']);
            foreach ($ingredients as $ingredient) {
                if ($ingredient->available_quantity_in_grams < ($productIngredients[$ingredient->id] * $quanity)) {
                    $fail('The required quantity of this product is not available.');
                }
            }

        }
    }

}
