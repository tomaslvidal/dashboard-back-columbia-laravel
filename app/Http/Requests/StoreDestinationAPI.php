<?php

namespace Columbia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationAPI extends FormRequest
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
            'title' => 'string|max:60',
            'subtitle' => 'string|max:60',
            'description' => 'string|max:191',
            'image1' => 'file|image',
            'image2' => 'file|image',
            'image3' => 'file|image',
            'image4' => 'file|image',
        ];
    }
}
