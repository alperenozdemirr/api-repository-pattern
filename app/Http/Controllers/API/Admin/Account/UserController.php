<?php

namespace App\Http\Controllers\API\Admin\Account;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\UserRepository;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\Public\FileRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Resources\Public\FileResource;
use App\Http\Services\FileService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $repository = null;
    private $fileService = null;
    public function __construct(UserRepository $repository,FileService $fileService)
    {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->filter();
        if($items){
            return response()->json(['message' => 'Items have been listed successfully', 'items' => UserResource::collection($items)],200);
        }
        return response()->json(['message' => 'The item could not be found'], 404);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => UserResource::make($item)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
    }


    /**
     * @param $id
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id ,UpdateUserRequest $request)
    {
        $item = $this->repository->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => UserResource::make($item)],200);

        } else return response()->json(['error' => 'Failed to updated the item'],422);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $user = $this->repository->find($id);
        if($user){
            $image = $user->image;
            if ($image) {
                $imageDeleted = $this->fileService->fileDelete($image->id);
                if (!$imageDeleted) {
                    return response()->json(['error' => 'Failed to delete the image'], 400);
                }
            }

            $deleted = $user->delete();
            if ($deleted) {
                return response()->json(['message' => 'User and its image have been deleted'], 204);
            } else return response()->json(['error' => 'Failed to delete the item'], 400);

        } else {
            return response()->json(['error' => 'The item could not be found'],400);
        }
    }
}
