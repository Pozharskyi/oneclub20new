<?php

namespace App\Http\Requests\Product;
use Illuminate\Foundation\Http\FormRequest;

class CreateSubProductRequest extends FormRequest
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
            'barcode' => 'required|unique:dev_sub_product,barcode',
            'markup_price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'delivery_days' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'barcode.required' => 'barcode is required',
            'barcode.unique' => 'barcode must be unique',
            'markup_price.required' => 'markup_price is required',
            'quantity.required' => 'quantity is required',
            'delivery_days.required' => 'delivery_days is required',
        ];
    }
}
