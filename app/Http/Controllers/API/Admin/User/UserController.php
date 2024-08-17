<?php

namespace App\Http\Controllers\API\Admin\User;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\UserRepository;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Http\Services\FileService;

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
        return ResponseHelper::forbidden();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $item = $this->repository->get($id);
        if($item){
            activity()->log('log try');
            return response()->json(['message' => 'Items have been listed successfully','item' => UserResource::make($item)],200);
        }else{
            return ResponseHelper::forbidden();
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

        } else return ResponseHelper::failedUpdate();
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
                    return ResponseHelper::failedDelete();
                }
            }

            $deleted = $user->delete();
            if ($deleted) {
                return response()->json(['message' => 'User and its image have been deleted'], 204);
            } else return ResponseHelper::failedDelete();

        } else {
            return ResponseHelper::forbidden();
        }
    }
}
