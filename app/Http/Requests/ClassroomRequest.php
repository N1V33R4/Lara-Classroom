<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClassroomRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    protected function prepareForValidation()
    {
        // must do this in order to validate json
        $this->merge([
            'lecturers_list' => json_decode($this->input('lecturers_list'), true)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required|min:5|max:255'
            'name' => ['required', Rule::unique('classrooms', 'name')->ignore($this->id)],
            'department_id' => 'required',
            'room_id' => 'required',
            'course_program_id' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
            'batch' => 'required|numeric',
            'year' => 'required|numeric|between:1,4',
            'semester' => 'required|numeric|between:1,2',
            'status' => 'required',

            'lecturers_list.*.lecturer_id' => 'required|distinct',
            'lecturers_list.*.order' => 'required|distinct|numeric|between:1,5'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'lecturers_list.*.lecturer_id.distinct' => 'Please check that there are no duplicate lecturers.',
            'lecturers_list.*.order.distinct' => 'Please check that there is no duplicate order.'
        ];
    }
}
