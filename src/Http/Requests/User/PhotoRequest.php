<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Requests\User;

use App\Http\Requests\Request;

class PhotoRequest extends Request
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
            'photo'   => 'max:5120|image'
        ];
    }
}