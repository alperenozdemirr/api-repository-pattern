<?php

namespace App\Http\Controllers\API\User\Category;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\CategoryRepository;
use App\Http\Requests\User\CategoryRequest;
use App\Http\Resources\User\CategoryResource;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $repository = null;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $item =  $this->repository->create($request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully created.','item' => new CategoryResource($item)]);
        } else {
            return response()->json(['error' => "Failed to created the item"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => CategoryResource::make($item)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, CategoryRequest $request)
    {
        $item = $this->repository->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => CategoryResource::make($item)]);
        } else {
            return response()->json(['error' => 'Failed to updated the item']);
        }
    }
    public function destroy($id)
    {
        $item = $this->repository->delete($id);
        if($item){
            return response()->json(['message' => 'Items have been item deleted']);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }
}
