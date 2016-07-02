<?php

namespace ErenMustafaOzdal\LaravelUserModule\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class UserPolicy
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
     * determine if the user index not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function index(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('admin.user.index');
    }

    /**
     * determine if the user create not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function create(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('admin.user.create');
    }

    /**
     * determine if the user store not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function store(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('admin.user.store');
    }

    /**
     * determine if the user show not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function show(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }

        return Sentinel::hasAccess('admin.user.show');
    }

    /**
     * determine if the user edit not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function edit(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }

        return Sentinel::hasAccess('admin.user.edit');
    }

    /**
     * determine if the user update not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function update(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }

        return Sentinel::hasAccess('admin.user.update');
    }

    /**
     * determine if the user changePassword not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function changePassword(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }

        return Sentinel::hasAccess('admin.user.changePassword');
    }

    /**
     * determine if the user permission not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function permission(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }

        return Sentinel::hasAccess('admin.user.permission');
    }

    /**
     * determine if the user destroy not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function destroy(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return false;
        }

        return Sentinel::hasAccess('admin.user.destroy');
    }

    /**
     * determine if the user index api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function indexApi(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('api.user.index');
    }

    /**
     * determine if the user detail api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function detailApi(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }
        return Sentinel::hasAccess('api.user.detail');
    }

    /**
     * determine if the user fast edit api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function fastEditApi(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }
        return Sentinel::hasAccess('api.user.fastEdit');
    }

    /**
     * determine if the user store api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function storeApi(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('api.user.store');
    }

    /**
     * determine if the user update api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function updateApi(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }
        return Sentinel::hasAccess('api.user.update');
    }

    /**
     * determine if the user destroy api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function destroyApi(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return false;
        }

        return Sentinel::hasAccess('api.user.destroy');
    }

    /**
     * determine if the user activate api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function activateApi(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('api.user.activate');
    }

    /**
     * determine if the user not activate api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function notActivateApi(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('api.user.notActivate');
    }

    /**
     * determine if the user group api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function groupApi(User $auth_user, User $user)
    {
        return Sentinel::hasAccess('api.user.group');
    }

    /**
     * determine if the user destroy avatar api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function destroyAvatarApi(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }
        return Sentinel::hasAccess('api.user.destroyAvatar');
    }

    /**
     * determine if the user avatar api not authorization for the auth user
     *
     * @param User $auth_user
     * @param User $user
     * @return bool
     */
    public function avatarPhotoApi(User $auth_user, User $user)
    {
        if ($auth_user->id === $user->id) {
            return true;
        }
        return Sentinel::hasAccess('api.user.avatarPhoto');
    }
}
