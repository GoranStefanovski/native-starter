<?php

namespace App\Applications\Common\Requests;

use App\Http\Requests\ApiFormRequest;


class LocationContactRequest extends ApiFormRequest
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
            
        ];

        return $rules;
    }
    public function messages(){
        return [
           
        ];
    }
}
