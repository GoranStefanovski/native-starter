<?php

namespace App\Applications\PageBuilder\Requests;

use App\Http\Requests\ApiFormRequest;


class SimpleContentRequest extends ApiFormRequest
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
        return [
            'title' => 'required|max:255|min:2',
            'description' => 'required',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'validation.name.required',
            'description.required' => 'validation.display_name.required',
        ];
    }
}
