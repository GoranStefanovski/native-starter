<?php

namespace App\Applications\Common\Requests;

use App\Http\Requests\ApiFormRequest;


class EventRequest extends ApiFormRequest
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
            'title' => 'required|max:255|min:2',
            'location_id' => 'required',
            'description' => 'required',
            'uploaded_file' => 'file|mimes:jpeg,jpg,png,gif|max:30000',
        ];

        return $rules;
    }
    public function messages(){
        return [
            'title.max' => 'Title too long.',
            'title.min' => 'Title too short',
            'body.min' => 'Text too short.',
            'id.required' => 'Post id is missing.',
            'user_id.required' => 'User id is missing.'
        ];
    }
}
