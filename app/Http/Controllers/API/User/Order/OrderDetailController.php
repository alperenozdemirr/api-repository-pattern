<?php

namespace App\Http\Controllers\API\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\OrderDetailRepository;
use App\Http\Requests\User\OrderDetailRequest;
use App\Http\Resources\User\OrderDetailResource;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    protected $repository = null;
    public function __construct(OrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }
    public function index($orderId)
    {
        $items= $this->repository->filter('order_id',$orderId);
        if($items){
            return response()->json(['message' => 'Items have been listed successfully','items' => OrderDetailResource::collection($items)],200);
        }else{
            return response()->json(['message' => 'The item could not be found'],404);
        }
    }


    public function create($orderId)
    {
        $item =  $this->repository->create($orderId);
        if($item){
            return response()->json(true,201);
        } else {
            return response()->json(false,422);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
