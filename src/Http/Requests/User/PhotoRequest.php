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
            'photo'     => 'required|max:5120|image|mimes:jpeg,jpg,png',
            'x'         => 'integer',
            'y'         => 'integer',
            'width'     => 'integer',
            'height'    => 'integer',
        ];
    }
}
