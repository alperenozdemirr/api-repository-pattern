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
        $items =  $this->repository->create($request->safe()->all());
        if($items){
            return response()->json(['message' => 'The item has been successfully created.','item' => new CategoryResource($items)]);
        } else {
            return response()->json(['error' => 'Failed to created the item']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
