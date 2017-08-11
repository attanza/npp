<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->id == Auth::id()) {
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
            'first_name' => 'required|max:200',
            'last_name' => 'nullable|max:200',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'username' => 'required|max:100|unique:users,username,'.$this->id,
            'dob' => 'required|date',
            'gender' => 'required|max:10'
        ];
    }
}
