<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculationRequest extends FormRequest
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
            'name' => 'required|max:255|unique:calculations,name,' . ($this->id ?? 0), 
            'customer_id' => 'integer|required',
            //'sum' => 'decimal:0,2|min:10|max:1000000|required', 
            'days' => 'integer|nullable',
            'works' => 'array',
            'comments' => 'string|nullable'
        ];
    }
}
