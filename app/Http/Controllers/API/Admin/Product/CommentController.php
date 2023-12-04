<?php

namespace App\Http\Controllers\API\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\CommentRepository;
use App\Http\Requests\Admin\UpdateCommentRequest;
use App\Http\Requests\User\CommentRequest;
use App\Http\Resources\Public\CommentResource;
use App\Http\Services\FileService;
use Illuminate\Http\Request;
use function Symfony\Component\Translation\t;

class CommentController extends Controller
{
    private $repository = null;

    public function __construct(CommentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $items= $this->repository->filter();
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => CommentResource::collection($items)],200);
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
            return response()->json(['message' => 'Items have been listed successfully','item' => CommentResource::make($item)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductComments($id){
        $items= $this->repository->get($id);
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => CommentResource::collection($items)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
    }

    /**
     * @param $id
     * @param UpdateCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCommentRequest $request,FileService $fileService)
    {
        $item = $this->repository->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => CommentResource::make($item)],200);

        } else return response()->json(['error' => 'Failed to updated the item'],422);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->delete($id);
        if($item){
            return response()->json(['message' => 'Items have been item deleted'],204);
        }else{
            return response()->json(['error' => 'Failed to delete the item'],400);
        }
    }


}
