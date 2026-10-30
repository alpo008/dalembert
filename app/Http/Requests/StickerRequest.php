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
            'contact_name' => 'required|max:50', 
            //'contact_email' => 'nullable|max:100|string|email:rfc,dns',
            'contact_email' => 'nullable|max:100|string|email',
            'contact_phone' => 'required_without:contact_email|max:30|string|regex:/^\+?\d{9,14}?$/',
            'priority' => 'integer|between:1,3',
            'message' => 'nullable|string',
            'doi' => 'date',
            'valid_until' => 'date',
            'link_text' => 'nullable|max:127',
            'link_address' => 'required_with:link_text|nullable|max:255',
            'files' => 'sometimes',
            'files.*' => File::types(['jpg', 'png' , 'jpeg', 'tiff'])->max(2048)
        ];
    }
}
