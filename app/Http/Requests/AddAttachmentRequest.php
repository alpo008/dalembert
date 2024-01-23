<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
//use Illuminate\Support\Facades\DB;

class AddAttachmentRequest extends FormRequest
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
        //$tables = DB::select('SHOW TABLES');
        return [
            'morphable_type' => 'string|max:255|required',
            'morphable_id' => 'integer|required',
            'name' => 'required|max:100',
            'collection' => 'required|max:50',
            'doi' => 'date|nullable',
            'description' => 'string|nullable',
            'file' => ['required', File::types(['jpg', 'png' , 'jpeg', 'tiff', 'pdf'])->max(2048)]
        ];
    }
}
