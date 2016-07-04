<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Requests\Role;

use App\Http\Requests\Request;
use Sentinel;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Sentinel::getUser()->is_super_admin || Sentinel::hasAccess('admin.role.update')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'max:255',
            'slug'          => 'alpha_dash|max:255|unique:roles,slug,'.$this->segment(3),
            'permissions'   => 'array',
        ];
    }
}
