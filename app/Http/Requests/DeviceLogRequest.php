<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceLogRequest extends FormRequest
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
            'model' => 'nullable|string', 
            'platform' => 'nullable|string', 
            'uuid' => 'nullable|string', 
            'version' => 'nullable|string', 
            'manufacturer' => 'nullable|string', 
            'serial' => 'nullable|string', 
            'action' => 'string'
        ];
    }
}
