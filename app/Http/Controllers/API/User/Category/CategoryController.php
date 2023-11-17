<?php

namespace App\Http\Controllers\API\User\Category;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\CategoryRepository;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Public\CategoryResource;

class CategoryController extends Controller
{
    private $repository = null;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->all();
        $items->load('parent');
        $items->load('children');
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => CategoryResource::collection($items)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }
}
