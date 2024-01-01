<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Public\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'phone' => $this->phone ?? null,
            'image' => $this->image->file_path ?? null,
            'status' => $this->status,
            'type' => $this->type,
        ];
    }
}
