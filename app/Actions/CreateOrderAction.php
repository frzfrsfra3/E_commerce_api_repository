<?php 

// app/Actions/CreateOrderAction.php

namespace App\Actions;

use App\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\ValidatesRequests;

class CreateOrderAction
{
    use ApiResponser, ValidatesRequests;

    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(Request $request)
    {
        $this->validateRequest($request, [
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $totalPrice = calculateTotalPrice($request->products);

        $order = $this->orderRepository->create([
            'user_id' => $request->user()->id,
            'total_price' => $totalPrice,
            'products' => $request->products
        ]);

        return $this->successResponse($order, 201);
    }
}
