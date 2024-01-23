<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class AddPaymentRequest extends FormRequest
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
            'payer_type' => 'string|max:255|required',
            'payer_id' => 'integer|required',
            'doi' => 'date',
            'amount' => 'decimal:0,2|min:100|max:200000|required',
            'destination' => 'required|string|max:255',
            'comments' => 'string|nullable',
            'file' => ['sometimes', File::types(['jpg', 'png' , 'jpeg', 'tiff', 'pdf'])->max(2048)]
        ];
    }
}