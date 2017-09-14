<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = Auth::user()->getRole();
        if ($role == 'administrator' || $role = 'customer-service') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|max:50|unique:products,code'.$this->id,
            'name' => 'required|max:200|unique:products,name'.$this->id,
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'description' => 'nullable|string'
        ];
    }
}
