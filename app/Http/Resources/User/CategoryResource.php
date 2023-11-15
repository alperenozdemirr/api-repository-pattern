<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'parent' => CategoryResource::collection($this->parent) ?? null,
            'children' => CategoryResource::collection($this->children) ?? null,
            'order' => $this->order ?? null
        ];
    }
}
