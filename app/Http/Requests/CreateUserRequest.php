<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       /* if(Auth::guest()){
            return false;
        }*/
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
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'role_code' => 'required',
            'department_code' => 'required',
            'category_code' => 'required',
            'org_code' => 'required',
            'email' => 'required|email',
            'staff_number'=>'required|min:2',
            'contract_start_date'=>'required|date',
            'contract_expiry_date'=>'required|date',
            'date_of_birth'=>'required|date',
            'designation'=>'required|min:2',
        ];
    }
}
