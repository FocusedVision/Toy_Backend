<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class TokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'session_token' => ['required', 'string', 'min:16', 'max:16'],
            'signature' => ['required', 'string', 'min:64', 'max:64'],
            'device_id' => ['nullable', 'string', 'max:255'],
        ];
    }
}
