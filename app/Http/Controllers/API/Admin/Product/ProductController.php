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

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->filter();
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => ProductResource::collection($items)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
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
            return response()->json(['message' => 'The item has been successfully created.','item' => new ProductResource($items)],201);
        } else {
            return response()->json(['error' => 'Failed to created the item'],422);
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
            return response()->json(['message' => 'Items have been listed successfully','item' => ProductResource::make($item)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
    }

    /**
     * @param $id
     * @param ProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id ,ProductRequest $request)
    {
        $item = $this->repository->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => ProductResource::make($item)],200);

        } else return response()->json(['error' => 'Failed to updated the item'],422);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $product = $this->repository->find($id);
        if($product){
            $this->repository->delete($id);
            return response()->json(['message' => 'Items have been item deleted'],204);
        }else{
            return response()->json(['error' => 'Failed to delete the item'],400);
        }
    }

    /**
     * @param string $search
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(string $search)
    {
        $products = $this->repository->search('name',$search);
        $message = "Found (". $products->count() . ") results for the phrase '".$search."' in products";
        if($products){
            return response()->json(
                [
                    'message' => $message,
                    'count' => $products->count(),
                    'item' => ProductResource::collection($products),
                ],200);

        }
        return response()->json(['message' => $message],404);
    }
}
