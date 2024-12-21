<?php  

if (!function_exists('calculateTotalPrice')) {
    function calculateTotalPrice($products)
    {
        return array_reduce($products, function ($total, $product) {
            return $total + ($product['price'] * $product['quantity']);
        }, 0);
    }
}
