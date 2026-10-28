<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteSettingRequest extends FormRequest
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
            'key' => 'required|string|max:255', 
            'value' => 'required|string',
            'locale' => 'required|string|max:2',
            'comment' => 'nullable|string|max:255'
        ];
    }
}
