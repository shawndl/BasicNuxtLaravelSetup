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
            'name' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|image'
        ];
    }
}