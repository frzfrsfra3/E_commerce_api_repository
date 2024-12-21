<?php


namespace App\Actions\ProductActions;

use App\Domain\ProductService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CreateProductAction
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
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
            ]);

            $product = $this->productService->create($data);

            return $this->responder->withData($product->toArray())->respond();
        } catch (ValidationException $e) {
            return $this->responder->withData(['errors' => $e->errors()])->withStatus(422)->respond();
        }
    }
}
