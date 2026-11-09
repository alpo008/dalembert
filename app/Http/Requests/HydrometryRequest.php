<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HydrometryRequest extends FormRequest
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
            'level_headwater_iv' => 'integer|nullable',
            'level_local' => 'integer|nullable',
            'temp_ext' => 'decimal:0,2|nullable',
            'temp_local' => 'decimal:0,2|nullable',
            'ice_thickness_ext' => 'integer|nullable',
            'ice_thickness_local' => 'integer|nullable',
            'turbulence' => 'integer|nullable'
        ];
    }
}
