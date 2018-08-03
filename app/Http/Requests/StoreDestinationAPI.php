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
        $return = array(
            'title' => 'string|required|max:60',
            'subtitle' => 'string|required|max:60',
            'description' => 'string|max:191',
            'image1' => 'file|image|size:3000',
            'image2' => 'file|image|size:3000',
            'image3' => 'file|image|size:3000',
            'image4' => 'file|image|size:3000',
        );

        if($this->method()!="PUT" && $this->method()!="PATCH"){
            foreach ($return as $key => $value) {
                if($key!="description" && $key!="image1" && $key!="image2" && $key!="image3" && $key!="image4"){
                    $return[$key] = $value."|required";
                }
            }
        }

        return $return;
    }
}
