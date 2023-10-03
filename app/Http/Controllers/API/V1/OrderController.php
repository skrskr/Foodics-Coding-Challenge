<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;


class OrderController extends Controller
{

    public function store(OrderRequest $request)
    {

        return "validation ok";
    }
}
