<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addFriendToGroupREquest extends FormRequest
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
            "friendName" =>'required  ',
            "id" => 'required | exists:App\Group,id'

        ];
    }
    public function messages()
    {
        return [
            'friendName.required' => 'A vaild group friendName is required',
            'id.required' => 'you should enter group id',
            'id.exists' => 'you should enter an existant group'
            
        ];
    }
}
