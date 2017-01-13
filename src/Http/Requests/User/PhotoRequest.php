<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Requests\User;

use ErenMustafaOzdal\LaravelModulesBase\Requests\BaseRequest;
use Sentinel;

class PhotoRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return hasPermission('api.user.avatarPhoto');
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
            'photo'     => "required|max:{$max}|image|mimes:{$mimes}"
        ];
    }
}
