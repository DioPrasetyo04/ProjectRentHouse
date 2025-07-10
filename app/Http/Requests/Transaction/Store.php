<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === 'customer';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'listing_id' => ['required', 'exists:listings,id'],
            'start_date' => ['required','date'],
            'end_date' => ['required','date', 'after_or_equal:start_date'],
        ];
    }

    // membuat function error yang dapat menangani validation rule jika value yang diinput tidak sesuai dengan rules 
    protected function failedValidation(Validator $validator){
        $error = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation Errors',
                'data' => $error
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
