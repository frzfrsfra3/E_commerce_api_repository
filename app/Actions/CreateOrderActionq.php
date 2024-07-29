<?php

// app/Actions/CreateOrderAction.php

namespace App\Actions;

use App\Domain\OrderService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateOrderAction
{
    protected $orderService;
    protected $responder;

    public function __construct(OrderService $orderService, JsonResponder $responder)
    {
        $this->orderService = $orderService;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        try {
            $data = $request->validate([
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ]);

            $userId = $request->user()->id;
            $order = $this->orderService->createOrder($userId, $data);

            return $this->responder->withData($order->toArray())->respond();
        } catch (ValidationException $e) {
            return $this->responder->withData(['errors' => $e->errors()])->withStatus(422)->respond();
        }
    }
}
