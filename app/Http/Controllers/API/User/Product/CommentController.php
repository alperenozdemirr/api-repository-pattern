<?php

namespace App\Http\Controllers\API\User\Product;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\User\CommentRepository;
use App\Http\Requests\User\CommentRequest;
use App\Http\Resources\Public\CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private $repository = null;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($producId)
    {
        $items= $this->repository->filter('product_id',$producId);
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => CommentResource::collection($items)],200);
        }
        return ResponseHelper::forbidden();

    }

    /**
     * @param CommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentRequest $request)
    {
        $items =  $this->repository->create($request->safe()->all());
        if($items){
            return response()->json(['message' => 'The item has been successfully created.','item' => new CommentResource($items)],201);

        }
        return ResponseHelper::failedCreate();

    }
}
