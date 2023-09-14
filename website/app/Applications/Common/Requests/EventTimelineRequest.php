<?php

namespace App\Applications\Common\Requests;

use App\Http\Requests\ApiFormRequest;


class EventTimelineRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // we will handle this with middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = $this->request->get('roles'); // Get the input value

        $rules = [
            'start_date' => 'required',
            'start_time' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
        ];

        return $rules;
    }
    public function messages(){
        return [
            'start_date.mrequiredax' => 'Start Date Required',
            'start_time.required' => 'Start Time Required',
            'end_date.required' => 'End Date Required',
            'end_time.required' => 'End Time Required',
        ];
    }
}
