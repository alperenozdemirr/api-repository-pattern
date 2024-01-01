<?php

namespace App\Http\Controllers\API\Admin\Account;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\AccountRepository;
use App\Http\Requests\Public\ImageRequest;
use App\Http\Requests\User\AccountRequest;
use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $repository = null;

    /**
     * @param AccountRepository $repository
     */
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        $item = $this->repository->find(Auth::user()->id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','items' => UserResource::make($item)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
    }

    /**
     * @param AccountRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountRequest $request){
        $item = $this->repository->updateV2($request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => UserResource::make($item)],200);
        } else {
            return response()->json(['error' => 'Failed to updated the item'],422);
        }
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
}
