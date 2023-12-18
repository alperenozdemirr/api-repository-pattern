<?php

namespace App\Http\Controllers\API\User\Account;

use App\Http\Controllers\Controller;
use App\Http\Middleware\User;
use App\Http\Repositories\User\AccountRepository;
use App\Http\Requests\Public\FileRequest;
use App\Http\Requests\Public\ImageRequest;
use App\Http\Requests\User\AccountRequest;
use App\Http\Resources\Public\FileResource;
use App\Http\Resources\User\UserResource;
use App\Http\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    protected $repository = null;
    protected $fileService = null;
    public function __construct(AccountRepository $repository, FileService $fileService)
    {
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->find(Auth::user()->id);
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => UserResource::make($items)],200);

        }else return response()->json(['message' => 'The item could not be found'],404);
    }

    /**
     * @param AccountRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountRequest $request)
    {
        $item = $this->repository->update(Auth::user()->id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => UserResource::make($item)],200);

        } else return response()->json(['error' => 'Failed to updated the item'],422);
    }

    /**
     * @param ImageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function imageChange(ImageRequest $request){
        $item = $this->repository->imageChange($request->safe()->all());
        if($item){
            return response()->json(['message' => 'The image has been successfully updated.','item' => 'item'],200);

        } else return response()->json(['error' => 'Failed to updated the image'],422);
    }

    /**
     * @param FileRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileUpload(FileRequest $request){
        $item = $this->fileService->fileUpload($request->file);
        if($item){
            return response()->json(['message' => 'The file has been successfully updated.','item' => new FileResource($item)],200);

        } else return response()->json(['error' => 'Failed to updated the file'],422);
    }

    /**
     * @param $fileId
     * @return \Illuminate\Http\JsonResponse
     */
    public function fileDestroy($fileId){
        $item = $this->fileService->fileDelete($fileId);
        if ($item){
            return response()->json(['message' => 'Items have been file deleted'],204);

        } else return response()->json(['error' => 'Failed to delete the file'],400);
    }
}
