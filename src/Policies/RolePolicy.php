<?php

namespace ErenMustafaOzdal\LaravelUserModule\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use App\Role;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * before authorization policy
     *
     * @param User $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->is_super_admin) {
            return true;
        }
    }

    /**
     * determine if the role index not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function index(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.index');
    }

    /**
     * determine if the role create not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function create(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.create');
    }

    /**
     * determine if the role store not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function store(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.store');
    }

    /**
     * determine if the role show not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function show(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.show');
    }

    /**
     * determine if the role edit not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function edit(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.edit');
    }

    /**
     * determine if the role update not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function update(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.update');
    }

    /**
     * determine if the role destroy not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function destroy(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('admin.role.destroy');
    }

    /**
     * determine if the role index api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function indexApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.index');
    }

    /**
     * determine if the role detail api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function detailApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.detail');
    }

    /**
     * determine if the role fast edit api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function fastEditApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.fastEdit');
    }

    /**
     * determine if the role store api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function storeApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.store');
    }

    /**
     * determine if the role update api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function updateApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.update');
    }

    /**
     * determine if the role destroy api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function destroyApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.destroy');
    }

    /**
     * determine if the role group api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function groupApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.group');
    }

    /**
     * determine if the role get models api not authorization for the auth user
     *
     * @param User $auth_user
     * @param Role $role
     * @return bool
     */
    public function modelsApi(User $auth_user, Role $role)
    {
        return Sentinel::hasAccess('api.role.models');
    }
}
