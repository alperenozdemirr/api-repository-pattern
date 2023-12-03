<?php

namespace App\Http\Controllers\API\User\Account;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\ShoppingCartRepository;
use App\Http\Requests\User\ShoppingCartRequest;
use App\Http\Resources\Public\ShoppingCartResource;
use App\Http\Services\ShoppingCartService;
use Illuminate\Http\Request;

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
        $items= $this->repository->all();
        if($items){
            $data['itemAmount'] = $this->shoppingCartService->getTotalProductAmount();
            $data['totalPrice'] = $this->shoppingCartService->getTotalPrice();
            return response()->json([
                'message' => 'Items have been listed successfully',
                'items' => ShoppingCartResource::collection($items),
                'item_amount' => $data['itemAmount'],
                'total_price' => $data['totalPrice'],
            ]);
        }
        return response()->json(['message' => 'The item could not be found']);
    }


    public function store(ShoppingCartRequest $request)
    {
        $item = $this->repository->create($request->safe()->all());
        if ($item) {
            return response()->json(['message' => 'The item has been successfully created.', 'item' => $item]);
        }
        return response()->json(['error' => 'Failed to create the item']);
    }

    /**
     * @param $id
     * @param ShoppingCartRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, ShoppingCartRequest $request)
    {
        $checkId = $this->repository->find($id);
        if($checkId){
            $item = $this->repository->update($id, $request->safe()->all());
            if($item){
                return response()->json(['message' => 'The item has been successfully updated.','item' => ShoppingCartResource::make($item)]);

            } else return response()->json(['error' => 'Failed to updated the item']);
        }
        return response()->json(['message' => 'The item could not be found']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $item = $this->repository->delete($id);
        if ($item){
            return response()->json(['message' => 'Items have been item deleted']);
        }
        return response()->json(['message' => 'The item could not be found']);

    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function amountIncrement($id)
    {
        $item = $this->repository->amountIncrement($id);
        if($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => ShoppingCartResource::make($item)]);
        }
        return response()->json(['message' => 'The item could not be found']);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function amountDecrement($id){
        $item = $this->repository->amountDecrement($id);
        if($item === true){
            return response()->json(['message' => 'Items have been item deleted']);
        } elseif($item){
            return response()->json(['message' => 'Items have been listed successfully','item' => ShoppingCartResource::make($item)]);
        }
        return response()->json(['message' => 'The item could not be found']);
    }
}
