<?php

namespace App\Domain;

use App\Models\Product;

class ProductService
{
    public function create($data)
    {
        return Product::create($data);
    }

    public function update(Product $product, $data)
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function all()
    {
        return Product::all();
    }
}
