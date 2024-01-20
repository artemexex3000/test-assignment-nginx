<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|min:2|max:60',
            'email' => 'required|min:2|max:100|email:rfc,dns|unique:users,email',
            'position_id' => 'required|exists:positions,id',
//            'phone' => 'required|regex:^[\+]{0,1}380([0-9]{9})$',
            'phone' => ['required', 'regex:/^[\+]{0,1}380([0-9]{9})$/i'],
            'photo' => ['required', 'file', 'mimes:jpeg,jpg', 'max:5000', Rule::dimensions()->minWidth(70)->minHeight(70)],
        ];
    }
}
