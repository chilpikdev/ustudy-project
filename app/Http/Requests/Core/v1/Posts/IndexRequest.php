<?php

namespace App\Http\Requests\Core\v1\Posts;

use App\Http\Requests\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    use FailedValidation;

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
            'perpage' => 'nullable|integer|min:1|max:50',
            'page' => ['nullable', 'integer', 'min:1'],
            'search' => 'nullable|string|min:4',
            'from' => 'nullable|date|date_format:Y-m-d|required_with:to',
            'to' => 'nullable|date|date_format:Y-m-d|required_with:from',
            'sort' => 'nullable|string|in:popular,recommended'
        ];
    }
}
