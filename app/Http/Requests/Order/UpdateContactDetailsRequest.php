<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactDetailsRequest extends FormRequest
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
            'email' => 'required|email',
            'cell' => 'regex:/^[0-9]{9}$/',    //regex for 9 numbers only
            'f_name' => 'required|alpha',
            'l_name' => 'required|alpha',
            'city'  => 'required|alpha',

        ];
    }
    public function messages()
    {
        return [

        ];
    }
}
