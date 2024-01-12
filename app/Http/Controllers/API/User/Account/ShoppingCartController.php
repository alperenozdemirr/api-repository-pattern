<?php

namespace App\Http\Controllers\API\User\Account;

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
            $data['itemAmount'] = $this->shoppingCartService->getTotalProductAmount();
            $data['totalPrice'] = $this->shoppingCartService->getTotalPrice();
            return response()->json([
                'message' => 'Items have been listed successfully',
                'items' => ShoppingCartResource::collection($items),
                'item_amount' => $data['itemAmount'],
                'total_price' => $data['totalPrice'],
            ],200);
        }
        return response()->json(['message' => 'The item could not be found'], 404);
    }


    public function store(ShoppingCartRequest $request)
    {
        $item = $this->repository->create($request->safe()->all());
        if ($item) {
            return response()->json(['message' => 'The item has been successfully created.', 'item' => $item],201);
        }
        return response()->json(['error' => 'Failed to create the item'],422);
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

            } else return response()->json(['error' => 'Failed to updated the item'],422);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->authorized($id)->delete($id);
        if ($item){
            return response()->json(['message' => 'Items have been item deleted'],204);
        }
        return response()->json(['error' => 'Failed to delete the item'],400);
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
        return response()->json(['message' => 'The item could not be found'],404);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function amountDecrement($id){
        $item = $this->repository->authorized($id)->amountDecrement($id);
        if($item === true){
            return response()->json(['message' => 'Items have been item deleted'],204);
        } elseif($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => ShoppingCartResource::make($item)],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);
    }
}
