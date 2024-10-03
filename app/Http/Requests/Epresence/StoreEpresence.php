<?php

namespace App\Http\Requests\Epresence;

use Illuminate\Foundation\Http\FormRequest;

class StoreEpresence extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:IN,OUT'],
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Type is required',
            'type.in' => 'Type must be IN or OUT',
        ];
    }
}
