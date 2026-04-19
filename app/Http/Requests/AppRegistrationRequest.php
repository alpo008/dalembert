<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppRegistrationRequest extends FormRequest
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
            'app_id' => 'between:1,2', 
            'device_uuid' => 'required|string|size:16',
            'device_serial' => 'nullable|string',
//            'app_key' => 'string'
            'app_key' => [
                'required',
                    Rule::exists('app_registrations')->where(function ($query) {
                    $query->where('device_uuid', '=', NULL);
                }),
            ],
        ];
    }
}
