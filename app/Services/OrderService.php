<?php

namespace App\Services;

use App\Models\Ingredient;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Support\Facades\DB;

class OrderService
{
    
    public function createOrder(array $orderData): array
    {
        DB::beginTransaction();

        try {
            $productIds = array_column($orderData['products'], 'product_id');
    
            $products = Product::whereIn('id', $productIds)->pluck('price', 'id')->toArray();
    
            $order = $this->createNewOrder($orderData, $products);
    
            $this->createOrderProducts($order, $orderData, $products);
            
            $this->decreamentProductIngredientsQuantity($orderData);
           
            DB::commit();

            return [
                "success" => true,
                "data" => $order,
                "errors" => null 
            ];
        } catch (\Exception $e) {
            DB::rollback();
            return [
                "success" => false,
                "data" => null,
                "errors" => [$e->getMessage()] 
            ];
        }
    }

    private function createNewOrder(array $orderData, array $products): Order
    {
        $totalPrice = 0;
        foreach ($orderData["products"] as $item) {
            $totalPrice += ($item['quantity'] * $products[$item["product_id"]]);
        }
        $order = Order::create([
            'total' => $totalPrice
        ]);
        return $order;
    }

    private function createOrderProducts(Order $order, array $orderData, array $products): void
    {
        $orderProducts = [];
        foreach ($orderData["products"] as $item) {
            $orderProducts[] = [
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $products[$item["product_id"]],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        OrderProduct::insert($orderProducts);
    }

    private function decreamentProductIngredientsQuantity(array $orderData): void
    {
        foreach ($orderData["products"] as $item) {
            $productId = $item['product_id'];
            $productIngredients = ProductIngredient::where("product_id", $productId)->pluck('amount_in_grams','ingredient_id')->toArray();
            $ingredientIds = array_keys($productIngredients);
     
            foreach ($ingredientIds as $ingredientId) {
                Ingredient::where("id", $ingredientId)->decrement('available_quantity_in_grams', ($item['quantity'] * $productIngredients[$ingredientId]));
            }
            // TODO:: dispatch job to send email notification if ingredient quantity less than 50%
        }
    }
}
