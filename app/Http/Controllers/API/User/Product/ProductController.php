<?php

namespace App\Http\Controllers\API\User\Product;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\ProductRepository;
use App\Http\Resources\Public\ProductResource;

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
