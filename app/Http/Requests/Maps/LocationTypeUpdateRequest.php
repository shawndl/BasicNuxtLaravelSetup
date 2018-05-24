<?php

namespace App\Http\Requests\Maps;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationTypeUpdateRequest extends FormRequest
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
        $id = $this->route('locationType')->id;

        return [
            'name' => [
                'required', 'string', Rule::unique('location_types')->ignore($id),
            ],
            'description' => 'required|string',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'image' => 'nullable|mimes:png'
        ];
    }
}
