<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required|max:255|unique:customers,name,' . ($this->id ?? 0), 
            'email' => 'email:rfc,dns|nullable|unique:customers,email,' . ($this->id ?? 0),
            'phone' => 'nullable|regex:/^\+?\d{11,12}?$/|unique:customers,phone,' . ($this->id ?? 0),
            'location' => 'nullable',
            'location.lat' => 'decimal:2,18',
            'location.lng' => 'decimal:2,18',
            'address' => 'string|max:255|nullable',
            'comments' => 'string|nullable'
        ];
    }
}
