<?php

namespace App\Http\Controllers\API\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\OrderDetailRepository;

class OrderDetailController extends Controller
{
    protected $repository = null;
    public function __construct(OrderDetailRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $orderId
     * @return \Illuminate\Http\JsonResponse
     */
    public function create($orderId)
    {
        $item =  $this->repository->create($orderId);
        if($item){
            return true;
        } else {
            return false;
        }
    }
}
