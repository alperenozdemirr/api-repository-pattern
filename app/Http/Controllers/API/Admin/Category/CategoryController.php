<?php

namespace App\Http\Controllers\API\Admin\Category;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

use App\Http\Repositories\Admin\CategoryRepository;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Public\CategoryResource;
use Illuminate\Http\Request;

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
            return response()->json(['message' => 'Items have been listed successfully','items' => CategoryResource::collection($items)],200);
        }
        return ResponseHelper::forbidden();
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        $item =  $this->repository->create($request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully created.','item' => new CategoryResource($item)],201);

        } else return ResponseHelper::failedCreate();

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => CategoryResource::make($item)],200);
        }else{
            return ResponseHelper::forbidden();
        }
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, CategoryRequest $request)
    {
        $item = $this->repository->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => CategoryResource::make($item)],200);
        } else {
            return ResponseHelper::failedUpdate();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->delete($id);
        if($item){
            return ResponseHelper::successDeleted();
        }else{
            return ResponseHelper::failedDelete();
        }
    }
}
