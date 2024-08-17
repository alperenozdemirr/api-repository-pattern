<?php

namespace App\Http\Controllers\API\User\Order;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Repositories\User\OrderRepository;
use App\Http\Requests\User\OrderRequest;
use App\Http\Resources\User\OrderResource;
use Illuminate\Support\Facades\Auth;

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
        $items= $this->repository->filter('user_id',Auth::user()->id);
        if($items){
            return response()->json(
                [
                    'message' => 'Items have been listed successfully',
                    'count' => $items->count(),
                    'items' => OrderResource::collection($items),
                ],200);
        }
        return ResponseHelper::forbidden();
    }

    /**
     * @param OrderRequest $request
     * @param OrderDetailController $orderDetailController
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrderRequest $request, OrderDetailController $orderDetailController)
    {
        $item =  $this->repository->create($request->safe()->all());
        if($item){
            $orderDetails = $orderDetailController->create($item->id);
            if ($orderDetails){
                return response()->json(['message' => 'The item has been successfully created.','item' => new OrderResource($item)],201);
            }
        }
        return ResponseHelper::failedCreate();
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $items = $this->repository->authorized($id)->find($id);
        $items->load('order_details');
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => OrderResource::make($items)],200);
        }
        return response()->json(['message' => 'The item could not be found'],404);
    }
}
