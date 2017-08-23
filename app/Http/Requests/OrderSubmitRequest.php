<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSubmitRequest extends FormRequest
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
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|max:30',
            'qty' => 'required|integer',
            'address' => 'required|string',
            'product_id' => 'required|integer',
        ];
    }
}
