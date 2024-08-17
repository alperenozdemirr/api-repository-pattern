<?php

namespace App\Http\Controllers\API\User\Account;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\User\ShoppingCartRepository;
use App\Http\Requests\User\ShoppingCartRequest;
use App\Http\Resources\Public\ShoppingCartResource;
use App\Http\Services\ShoppingCartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    private $repository = null;
    protected $shoppingCartService;

    /**
     * @param ShoppingCartRepository $repository
     * @param ShoppingCartService $shoppingCartService
     */
    public function __construct(ShoppingCartRepository $repository, ShoppingCartService $shoppingCartService)
    {
        $this->repository = $repository;
        $this->shoppingCartService = $shoppingCartService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->filter('user_id',Auth::user()->id);
        if($items){
            return response()->json([
                'message' => 'Items have been listed successfully',
                'items' => ShoppingCartResource::collection($items),
                'item_amount' => $this->shoppingCartService->getTotalProductAmount(),
                'total_price' => $this->shoppingCartService->getTotalPrice(),
            ],200);
        }
        return ResponseHelper::forbidden();
    }


    public function store(ShoppingCartRequest $request)
    {
        $item = $this->repository->create($request->safe()->all());
        if ($item) {
            return response()->json(['message' => 'The item has been successfully created.', 'item' => $item],201);
        }
        return ResponseHelper::failedCreate();
    }

    /**
     * @param $id
     * @param ShoppingCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, ShoppingCartRequest $request)
    {
        $item = $this->repository->authorized($id)->update($id, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => ShoppingCartResource::make($item)],200);
            } else ResponseHelper::failedUpdate();
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

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function amountIncrement($id)
    {
        $item = $this->repository->authorized($id)->amountIncrement($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => ShoppingCartResource::make($item)],200);
        }
        return ResponseHelper::forbidden();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function amountDecrement($id){
        $item = $this->repository->authorized($id)->amountDecrement($id);
        if($item === true){
            return ResponseHelper::successDeleted();
        } elseif($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => ShoppingCartResource::make($item)],200);
        }
        return ResponseHelper::forbidden();
    }
}
