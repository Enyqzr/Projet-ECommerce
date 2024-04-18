<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Foundation\Http\FormRequest;


class ProductUserRequest extends FormRequest
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
            'user_id'=>['required', 'uuid'],
            'product_id'=>['required','uuid'],
            'comment'=>['required']
        ];
    }

    public function messages() {
        return [
            'user_id.required' => 'Le champ user_id est obligatoire',
            'user_id.uuid' => 'Le champ user_id doit être un UUID valide',
            'product_id.required'=> 'Le champ product-id  est obligatoire',
            'product_id.uuid'=> 'Le champ product-id  doit être un UUID valide',
            'comment.required'=> 'Le champ commentaire  est obligatoire'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = [
            'success' => false,
            'message' => 'Validation Error',
            'data' => $validator->errors(),
        ];

        throw new HttpResponseException(response()->json($response, 422));
    }


}
