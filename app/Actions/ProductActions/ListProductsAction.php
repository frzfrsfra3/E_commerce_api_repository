<?php

namespace App\Actions\ProductActions;

use App\Domain\ProductService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;

class ListProductsAction
{
    protected $productService;
    protected $responder;

    public function __construct(ProductService $productService, JsonResponder $responder)
    {
        $this->productService = $productService;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $products = $this->productService->all();
        return $this->responder->withData($products->toArray())->respond();
    }
}
