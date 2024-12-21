<?php



namespace App\Domain;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder($userId, $data)
    {
        return DB::transaction(function () use ($userId, $data) {
            $totalPrice = 0;

            foreach ($data['products'] as $product) {
                $productModel = Product::find($product['id']);
                $totalPrice += $productModel->price * $product['quantity'];
            }

            $order = Order::create(['user_id' => $userId, 'total_price' => $totalPrice]);

            foreach ($data['products'] as $product) {
                $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
                Product::find($product['id'])->decrement('quantity', $product['quantity']);
            }

            return $order;
        });
    }
}
