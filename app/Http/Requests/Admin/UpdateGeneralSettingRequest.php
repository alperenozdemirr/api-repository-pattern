<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralSettingRequest extends FormRequest
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
            'website_name' => 'nullable|string|max:255',
            'shipping_cost' => 'nullable|decimal:0,2',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|min:3|max:15',
            'email' => 'nullable|email|min:3|max:255',
            'address' => 'nullable|string|min:3',
        ];
    }
}
