<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'userTotalCount' => $this->userTotalCount,
            'userActiveCount' => $this->userActiveCount,
            'userPassiveCount' => $this->userPassiveCount,
            'adminCount' => $this->adminCount,
            'productTotalCount' => $this->productTotalCount,
            'basketTotalCount' => $this->basketTotalCount,
            'favoriteTotalCount' => $this->favoriteTotalCount,
            'orderAllCount' => $this->orderAllCount,
            'newOrders' => $this->newOrders,
            'beingProcessedOrders' => $this->beingProcessedOrders,
            'shippedOrders' => $this->shippedOrders,
            'deliveredOrders' => $this->deliveredOrders,
            'cancelledOrders' => $this->cancelledOrders,
            'totalPayment' => $this->totalPayment,
        ];
    }
}
