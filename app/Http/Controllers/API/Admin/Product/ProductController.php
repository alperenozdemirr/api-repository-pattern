<?php

namespace App\Http\Controllers\API\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\ProductRepository;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Resources\Public\ProductResource;
use App\Http\Services\ProductImageService;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $repository = null;
    protected $productImageService;

    public function __construct(ProductRepository $repository, ProductImageService $productImageService)
    {
        $this->repository = $repository;
        $this->productImageService = $productImageService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->all();
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => ProductResource::collection($items)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        $items =  $this->repository->create($request->safe()->all());
        if($items){
            return response()->json(['message' => 'The item has been successfully created.','item' => new ProductResource($items)]);
        } else {
            return response()->json(['error' => 'Failed to created the item']);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => ProductResource::make($item)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

    /**
     * @param $id
     * @param ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id ,ProductRequest $request)
    {
        $checkId = $this->repository->find($id);
        if(!empty($checkId)){
            $item = $this->repository->update($id, $request->safe()->all());
            if($item){
                return response()->json(['message' => 'The item has been successfully updated.','item' => ProductResource::make($item)]);

            } else return response()->json(['error' => 'Failed to updated the item']);

        } else return response()->json(['message' => 'The item could not be found']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $this->repository->delete($id);
            return response()->json(['message' => 'Items have been item deleted']);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }
}
