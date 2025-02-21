<?php

namespace App\Http\Requests\Admin\v1\Posts;

use App\Http\Requests\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'id' => 'required|integer|exists:orders,id',
            'title' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:255',
            'content' => 'required|string|min:1',
            'recommended' => 'required|boolean',
        ];
    }
}
