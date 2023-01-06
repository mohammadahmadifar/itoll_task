<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'latitude_receive' => ['required', 'string', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude_receive' => ['required', 'string', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'address_receive' => ['required', 'string'],
            'latitude_delivery' => ['required', 'string', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude_delivery' => ['required', 'string', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'address_delivery' => ['required', 'string'],
            'name_sender' => ['required', 'string'],
            'mobile_sender' => ['required', 'string'],
            'name_delivery' => ['required', 'string'],
            'mobile_delivery' => ['required', 'string'],
        ];
    }
}
