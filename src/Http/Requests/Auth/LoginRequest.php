<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Requests\Auth;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends Request
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
            'email'         => 'required|email|max:255',
            'password'      => 'required|min:6|max:255',
        ];
    }
}
