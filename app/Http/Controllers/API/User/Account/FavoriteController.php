<?php

namespace App\Http\Controllers\API\User\Account;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\User\FavoriteRepository;
use App\Http\Requests\User\FavoriteRequest;
use App\Http\Resources\Public\FavoriteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    private $repository = null;

    /**
     * @param FavoriteRepository $repository
     */
    public function __construct(FavoriteRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->filter('user_id',Auth::user()->id);
        if($items){
            return response()->json(
                [
                    'message' => 'Items have been listed successfully',
                    'count' => $items->count(),
                    'items' => FavoriteResource::collection($items),
                ],200);
        }
        return ResponseHelper::forbidden();
    }

    /**
     * @param FavoriteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FavoriteRequest $request)
    {
        $item = $this->repository->create($request->safe()->all());
        if ($item) {
            return response()->json(['message' => 'The item has been successfully created.', 'item' => new FavoriteResource($item)],201);
        }
        return ResponseHelper::failedCreate();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->authorized($id)->delete($id);
        if ($item){
            return ResponseHelper::successDeleted();
        }
        return ResponseHelper::failedDelete();
    }
}
