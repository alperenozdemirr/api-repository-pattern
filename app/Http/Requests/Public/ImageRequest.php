<?php

namespace App\Http\Requests\Public;

use App\Enums\ContentType;
use App\Enums\FileType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'file_type' => ['nullable|string|max:255',new Enum(FileType::class)],
            'content_type' => ['nullable|string|max:255',new Enum(ContentType::class)],
        ];
    }
}
