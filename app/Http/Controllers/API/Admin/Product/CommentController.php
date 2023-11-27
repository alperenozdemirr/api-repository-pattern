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
            return response()->json(['message' => 'Items have been listed successfully','items' => CommentResource::collection($items)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
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
            return response()->json(['message' => 'Items have been listed successfully','item' => CommentResource::make($item)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductComments($id){
        $items= $this->repository->get($id);
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => CommentResource::collection($items)]);
        }else{
            return response()->json(['message' => 'The item could not be found']);
        }
    }

    /**
     * @param $id
     * @param UpdateCommentRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCommentRequest $request,FileService $fileService)
    {
        $fileService->fileUpload();
        $checkId = $this->repository->find($id);
        if(!empty($checkId)){
            $item = $this->repository->update($id, $request->safe()->all());
            if($item){
                return response()->json(['message' => 'The item has been successfully updated.','item' => CommentResource::make($item)]);

            } else return response()->json(['error' => 'Failed to updated the item']);

        } else return response()->json(['message' => 'The item could not be found']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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
