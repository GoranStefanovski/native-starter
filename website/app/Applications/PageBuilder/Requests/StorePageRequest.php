<?php

namespace App\Applications\PageBuilder\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'title' => 'required|string',
            'body' => 'required|string',
            'slug' => 'required|alpha_dash|unique:pages,slug',
        ];
    }

    /**
     * Get the validation error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'body.required' => 'The body field is required.',
            'body.string' => 'The body must be a string.',
            'slug.required' => 'The slug field is required.',
            'slug.alpha_dash' => 'The slug may only contain letters, numbers, dashes, and underscores.',
            'slug.unique' => 'The slug has already been taken.',
        ];
    }
}
