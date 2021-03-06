<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Requests\Role;

use ErenMustafaOzdal\LaravelModulesBase\Requests\BaseRequest;
use Sentinel;

class StoreRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return hasPermission('admin.role.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|max:255',
            'slug'          => 'alpha_dash|max:255|unique:roles',
            'permissions'   => 'array',
        ];
    }
}
