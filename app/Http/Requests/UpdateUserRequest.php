<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    function rules()
    {
        return [
            'phone' => 'regex:/^[0-9]{9}$/',    //regex for 9 numbers only
            'email' => 'required|email|unique:users,email,' . $this->id,
            'gender' => 'in:Male,Female',
            'date_of_birth' => 'date',
            'name' => 'regex:/^[\pL\s]+$/u',     //regex for letters with spaces
            'f_name' => 'required|alpha',
            'l_name' => 'required|alpha',
        ];
    }

    public function messages()
    {
        return [
            'f_name.required' => 'f_name is required',
            'l_name.required' => 'l_name is required',
        ];
    }
}
