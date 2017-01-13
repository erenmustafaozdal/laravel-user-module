<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Requests\User;

use ErenMustafaOzdal\LaravelModulesBase\Requests\BaseRequest;
use Sentinel;

class UpdateRequest extends BaseRequest
{
    /**
     * The input keys that should not be flashed on redirect.
     *
     * @var array
     */
    protected $dontFlash = ['photo','roles'];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return hasPermission('admin.user.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $max = config('laravel-user-module.user.uploads.photo.max_size');
        $mimes = config('laravel-user-module.user.uploads.photo.mimes');
        return [
            'first_name'    => 'required|max:255',
            'last_name'     => 'required|max:255',
            'slug'          => 'email|max:255|unique:users,slug,'.$this->segment(3), // id
            'password'      => 'confirmed|min:6|max:255',
            'photo'         => "max:{$max}|image|mimes:{$mimes}",
            'permissions'   => 'array',
        ];
    }
}
