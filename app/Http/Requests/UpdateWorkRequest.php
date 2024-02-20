<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkRequest extends FormRequest
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
            'title' => 'required|max:255|unique:works,title,' . ($this->id ?? 0), 
            'unit' => 'string|required',
            'price' => 'decimal:0,2|min:10|max:100000|required', 
            'category' => 'string|required',
            'comments' => 'string|nullable'
        ];
    }
}
