<?php


namespace App\Actions\ProductActions;

use App\Domain\ProductService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;

class DeleteProductAction
{
    protected $productService;
    protected $responder;

    public function __construct(ProductService $productService, JsonResponder $responder)
    {
        $this->productService = $productService;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, $id)
    {
        $product = $this->productService->find($id);
        $this->productService->delete($product);

        return $this->responder->withData(['message' => 'Product deleted'])->respond();
    }
}
