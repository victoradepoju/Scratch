<?php

namespace App\Http\Requests;

use App\Rules\IntegerArray;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|required', // or ['string', 'required']
            'body' => ['string', 'required'], // another way of applying rules is with an array
            'user_ids' => [
                'array',
                'required',
//                // to create custom rules (closure method). the other method is creating a dedicated rule class
//                function($attribute, $value, $fail){
//                    $integerOnly = collect($value)->every(fn ($element) => is_int($element));
//
//                    if(!$integerOnly){
//                        $fail($attribute . ' can only be integers.');
//                    }
//                }
                new IntegerArray(),
            ]
        ];
    }

    public function messages()
    {
        return [
            'body.required' => "Please enter a value for body.",
            'title.string' => "HEYYYYY use a string",
        ];
    }
}
