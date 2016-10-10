<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderDeliveryRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'delivery_f_name' => 'required|alpha',
            'delivery_l_name' => 'required|alpha',
            'delivery_phone' => 'regex:/^[0-9]{9}$/',    //regex for 9 numbers only

        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
