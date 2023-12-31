<?php

namespace App\Http\Controllers\API\Admin\Order;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Admin\OrderRepository;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Resources\Admin\OrderResource;


class OrderController extends Controller
{
    protected $repository = null;

    /**
     * @param OrderRepository $repository
     */
    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $items= $this->repository->filter();
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => OrderResource::collection($items)],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $items = $this->repository->find($id);
        $items->load('order_details');
        $items->load('user');
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => OrderResource::make($items)],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);
    }

    /**
     * @param $orderId
     * @param UpdateOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($orderId, UpdateOrderRequest $request)
    {
        $item = $this->repository->update($orderId, $request->safe()->all());
        if($item){
            return response()->json(['message' => 'The item has been successfully updated.','item' => OrderResource::make($item)],200);

        } else return response()->json(['error' => 'Failed to updated the item'],422);
    }

}
