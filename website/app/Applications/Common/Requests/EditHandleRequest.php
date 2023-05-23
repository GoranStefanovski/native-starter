<?php

namespace App\Applications\Common\Requests;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\ApiFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


class EditHandleRequest extends ApiFormRequest
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
            'display_name' => 'required|max:255|min:2'
        ];
    }
    public function messages(){
        return [
            'display_name.required' => 'validation.name.required',
            'display_name.max' => 'validation.name.max',
            'display_name.min' => 'validation.name.min',
        ];
    }
}
