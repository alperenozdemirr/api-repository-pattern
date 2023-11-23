<?php

namespace App\Http\Resources\Public;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product' => ProductResource::make($this->product),
            'user' => UserResource::make($this->user),
            'content' => $this->content,
            'status' => $this->status
        ];
    }
}
