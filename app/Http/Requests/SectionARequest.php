<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionARequest extends FormRequest
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
            'staff_file_number' => 'required|min:2',
            'appraisal_type' => 'required|min:2',
            'supervisor' => 'required|min:2',
            'hod' => 'required|min:2',
            'ed' => 'required|min:2',
            'appraisal_start_date' => 'required|date|min:2',
            'appraisal_end_date' => 'required|date|min:2',
            'surname' => 'required|min:2',
            'other_name' => 'required|min:2',
            'department' => 'required|min:2',
            'designation' => 'required|min:2',
            'dob' => 'required|date|min:2',
        ];

    }
}
