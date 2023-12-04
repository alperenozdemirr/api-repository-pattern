<?php

namespace App\Http\Controllers\API\User\Product;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\ProductRepository;
use App\Http\Requests\Admin\ProductRequest;
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
        $items= $this->repository->all();
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
}
