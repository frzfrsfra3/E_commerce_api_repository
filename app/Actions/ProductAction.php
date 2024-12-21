<?php 

namespace App\Actions;

use App\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\ValidatesRequests;

class ProductAction
{
    use ApiResponser, ValidatesRequests;

    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->all();
        return $this->successResponse($products);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product = $this->productRepository->create($request->all());

        return $this->successResponse($product, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric',
            'quantity' => 'integer',
        ]);

        $product = $this->productRepository->update($id, $request->all());

        return $this->successResponse($product);
    }

    public function destroy($id)
    {
        $this->productRepository->delete($id);
        return $this->successResponse(null, 204);
    }
}
