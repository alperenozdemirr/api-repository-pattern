<?php

namespace App\Http\Resources\Public;

use App\Http\Resources\Admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'file_name' => $this->file_name,
            'user' => UserResource::make($this->user) ?? null,
            'file_type' => $this->file_type,
            'content_type' => $this->content_type,
            'file_path' => $this->file_path,
        ];
    }
}
