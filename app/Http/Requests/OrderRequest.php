<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            "photo" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "status" => 'required',
            "meal" => 'required | exists:meals,id',
            "from" => 'required',
            "friends" => 'required | exists:App\User,id',
            "groups" => 'required | exists:App\Group,id',

        ];
    }
    public function messages()
    {
        return [];
    }
}
