<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAirmaxClientRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'place' => 'required|max:30|unique:airmax_clients,place,' . ($this->id ?? 0),
            'location' => 'nullable',
            'location.lat' => 'decimal:2,18',
            'location.lng' => 'decimal:2,18',
            'name' => 'required|string|max:100|nullable',
            'email' => 'email:rfc,dns|nullable|unique:airmax_clients,email,' . ($this->id ?? 0),
            'phone' => 'nullable|regex:/^\+?\d{11,12}?$/|unique:airmax_clients,phone,' . ($this->id ?? 0),
            'ap_model' => 'string|max:30|nullable',
            'wlan_mac' => 'mac_address|nullable',
            'lan_mac' => 'mac_address|nullable',
            'ap_mac' => 'mac_address|nullable',
            'ip_address' => '|required|ipv4|unique:airmax_clients,ip_address,' . ($this->id ?? 0),
            'router_model' => 'string|max:30|nullable',
            'router_mac' => 'mac_address|nullable',
            'router_ip_address' => 'ipv4|nullable',
            'ssid' => 'string|max:30|nullable',
            'password' => 'min:8|nullable',
            'installed_on' => 'date|nullable',
            'active' => 'boolean|nullable'
        ];
    }

    /**
     * Get the error messages for validation rules.
     *
     * @return array
     */
    public function messages():array
    {
        return [
            'regex' => __('The :attribute format is invalid'),
            'email' => __('The :attribute must be a valid email address'),
            'required' => __('The :attribute field is required'),
            'unique' => __('The :attribute has already been taken'),
            'string' => __('The :attribute must be a text string'),
            'max' => __('The :attribute must not be greater than :max characters'),
            'min' => __('The :attribute must not be smaller than :min characters'),
            'json' => __('The :attribute must be a valid JSON string'),
            'ipv4' => __('The :attribute must be a valid IPv4 address'),
            'mac_address' => __('The :attribute must be a valid MAC address'),
            'date' => __('The :attribute is not a valid date'),
            'password' => __('Weak password')
        ];
    }
}
