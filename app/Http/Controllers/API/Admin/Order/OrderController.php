<?php

namespace App\Http\Controllers\API\Admin\Order;

use App\Helpers\ResponseHelper;
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
    public function index($type = null)
    {
        $items= $this->repository->list($type);
        $orderCount = $items->count();
        if($items){
            return response()->json([
                'message' => 'Items have been listed successfully',
                'total_count' => $orderCount,
                'items' => OrderResource::collection($items),
            ],200);
        }
        return ResponseHelper::forbidden();
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
        return ResponseHelper::forbidden();
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

        } else return ResponseHelper::failedUpdate();
    }

    /**
     * @param string $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(string $user)
    {
        $orders = $this->repository->searchByUser($user);
        $message = "Found (". $orders->count() . ") results for the phrase '".$user."' in items";
        if($orders){
            return response()->json(['message' => $message,'items' => OrderResource::collection($orders)],200);
        }
        return response()->json(['message' => $message],404);
    }

}
