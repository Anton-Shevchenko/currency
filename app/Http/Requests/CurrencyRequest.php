<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseStatuses;

class CurrencyRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'from-currency' => 'required',
            'to-currency' => 'required',
        ];
    }

    protected function failedValidation(Validator $validator) : void
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], ResponseStatuses::HTTP_UNPROCESSABLE_ENTITY)
        );
    }

}
