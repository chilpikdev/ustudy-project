<?php

namespace App\Http\Requests\Core\v1\Posts;

use App\Http\Requests\Traits\FailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ShareRequest extends FormRequest
{
    use FailedValidation;

    /*
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /*
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'post_id' => 'required|integer|exists:posts,id',
        ];
    }
}
