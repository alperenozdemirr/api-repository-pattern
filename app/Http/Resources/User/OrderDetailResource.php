<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Public\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'product' => ProductResource::make($this->product),
            'product_price' => $this->product_price,
            'product_amount' => $this->product_amount,
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'total_order_details' => $this->collection->count(),
            ],
        ];
    }
}
