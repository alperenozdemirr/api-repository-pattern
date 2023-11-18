<?php

namespace App\Http\Resources\Public;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'title' => $this->title,
            'address' => $this->address,
            'city' => [
                'code' => $this->city_code,
                'name' => $this->city->name,
            ],
            'status' => $this->status
        ];
    }
}
