<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StickerRequest extends FormRequest
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
            'contact_name' => 'nullable|max:50', 
            //'contact_email' => 'nullable|max:100|string|email:rfc,dns',
            'contact_email' => 'nullable|max:100|string',
            'contact_phone' => 'nullable|max:30|string|regex:/^\+?\d{11,12}?$/',
            'priority' => 'integer|between:1,3',
            'message' => 'nullable|string',
            'doi' => 'date',
            'valid_until' => 'date',
            'file' => ['sometimes', File::types(['jpg', 'png' , 'jpeg', 'tiff'])->max(2048)]
        ];
    }
}
