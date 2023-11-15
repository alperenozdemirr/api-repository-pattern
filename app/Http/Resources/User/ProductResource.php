<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'original_price' => $this->original_price,
            'discount_price' => $this->discount_price,
            'stock' => $this->stock,
            'order' => $this->order ?? null, //highlight sorting
            'status' => $this->status,
        ];
    }
}
