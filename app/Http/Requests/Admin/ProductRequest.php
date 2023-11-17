<?php

namespace App\Http\Requests\Admin;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|integer',
            'original_price' => 'required|decimal:0,2|min:0.01',
            'discount_price' => 'required|decimal:0,2|min:0.01',
            'stock' => 'required|integer',
            'order' => 'nullable|integer',
            'status' => ['required|string|max:255',new Enum(Status::class)],
        ];
    }
}
