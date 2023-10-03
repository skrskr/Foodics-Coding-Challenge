<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\API\ResponseBuilder;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Services\OrderService;


class OrderController extends Controller
{

    private $orderService;

    function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function store(OrderRequest $request)
    {
        $orderData = $request->validated();
        $result = $this->orderService->createOrder($orderData);

        if($result['success']) {
            return ResponseBuilder::response($result['data'], "Order created sucessfull", $result['errors'], ResponseBuilder::CREATED);
        }
        
        return ResponseBuilder::response($result['data'], "Failed to create order", $result['errors'], ResponseBuilder::BAD_REQUEST);
    }
}
