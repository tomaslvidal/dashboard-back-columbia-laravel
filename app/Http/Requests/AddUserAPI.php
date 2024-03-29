<?php

namespace Columbia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Columbia\Rules\UniqueUserVoucher;

use Illuminate\Validation\Rule;

class AddUserAPI extends FormRequest
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
            'user_id' => ['numeric', 'exists:users,id', new UniqueUserVoucher($this->user_id, $this->id)],
        ];
    }
}
