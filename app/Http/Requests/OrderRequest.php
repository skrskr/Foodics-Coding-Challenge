<?php

namespace App\Http\Requests;

use App\Rules\IngredientQuantityAvailableRule;

class OrderRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'products' => ['required', 'array', new IngredientQuantityAvailableRule],
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => [ "required", " integer", "min:1"]
        ];
    }
}
