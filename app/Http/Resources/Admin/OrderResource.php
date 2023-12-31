<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Public\AddressResource;
use App\Http\Resources\Public\OrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => UserResource::make($this->user),
            'product_amount' => $this->product_amount,
            'total_price' => $this->total_price,
            'shipment_status' => $this->shipment_status,
            'address' => AddressResource::make($this->address),
            'invoice_address' => AddressResource::make($this->invoice_address),
            'shipping_cost' => $this->shipping_cost,
            'order_details' => OrderDetailResource::collection($this->order_details),
            'meta' => [
                'total_order_details' => $this->order_details->count(),
            ],
        ];
    }
}
