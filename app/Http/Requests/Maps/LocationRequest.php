<?php

namespace App\Http\Requests\Maps;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'type' => 'required|numeric',
            'description' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'sometimes|image|max:10000',
            'private' => 'required|boolean'
        ];
    }

    public function messages()
    {
        return [
            'type.numeric' => 'Please select a type of food'
        ];
    }
}
