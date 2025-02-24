<?php

namespace App\Http\Requests\Admin\v1\Posts;

use App\Http\Requests\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:1|max:255',
            'content' => 'required|string|min:1',
            'recommended' => 'nullable|boolean',
            'files' => 'required|array|max:5',
            'files.*' => 'required|file|mimes:png,jpg|max:4096',
        ];
    }
}
