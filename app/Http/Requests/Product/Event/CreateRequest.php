<?php

namespace App\Http\Requests\Product\Event;

use App\Enums;
use App\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateRequest extends FormRequest
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
            'type' => ['required', new Enum(Enums\ProductEvent::class)],
            'seconds' => ['required_if:type,'.Enums\ProductEvent::OPEN_TIME_SECONDS->value, 'integer', 'min:1', 'max:'. 3600],
        ];
    }
}
