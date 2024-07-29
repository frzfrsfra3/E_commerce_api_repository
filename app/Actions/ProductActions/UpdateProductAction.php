<?php


namespace App\Actions\ProductActions;

use App\Domain\ProductService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UpdateProductAction
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
        try {
            $data = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'price' => 'sometimes|required|numeric',
                'quantity' => 'sometimes|required|integer',
            ]);

            $product = $this->productService->find($id);
            $updatedProduct = $this->productService->update($product, $data);

            return $this->responder->withData($updatedProduct->toArray())->respond();
        } catch (ValidationException $e) {
            return $this->responder->withData(['errors' => $e->errors()])->withStatus(422)->respond();
        }
    }
}
