<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use App\Http\Requests;
use Sentinel;
use App\User;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseUserController;
use ErenMustafaOzdal\LaravelModulesBase\Repositories\FileRepository;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\User\StoreSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\StoreFail;
use ErenMustafaOzdal\LaravelUserModule\Events\User\UpdateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\UpdateFail;
use ErenMustafaOzdal\LaravelUserModule\Events\User\DestroySuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\DestroyFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateRemove;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ActivateFail;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\UpdateRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\PasswordRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\PermissionRequest;

class UserController extends BaseUserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('laravel-user-module.views.user.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $operation = 'create';
        return view(config('laravel-user-module.views.user.create'), compact('operation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->setFileOptions([config('laravel-user-module.user.uploads.photo')]);
        $this->setEvents([
            'success'           => StoreSuccess::class,
            'fail'              => StoreFail::class,
            'activationSuccess' => ActivateSuccess::class,
            'activationFail'    => ActivateFail::class
        ]);
        return $this->storeModel(User::class, 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view(config('laravel-user-module.views.user.show'), compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $operation = 'edit';
        return view(config('laravel-user-module.views.user.edit'), compact('user','operation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        $this->setFileOptions([config('laravel-user-module.user.uploads.photo')]);
        return $this->updateAlias($user,[
            'success'           => UpdateSuccess::class,
            'fail'              => UpdateFail::class,
            'activationSuccess' => ActivateSuccess::class,
            'activationFail'    => ActivateFail::class,
            'activationRemove'  => ActivateRemove::class
        ], 'show');
    }

    /**
     * change user password
     *
     * @param  PasswordRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function changePassword(PasswordRequest $request, User $user)
    {
        return $this->updateAlias($user,[
            'success'           => UpdateSuccess::class,
            'fail'              => UpdateFail::class
        ], 'show');
    }

    /**
     * change user permission
     *
     * @param  PermissionRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function permission(PermissionRequest $request, User $user)
    {
        return $this->updateAlias($user,[
            'success'           => UpdateSuccess::class,
            'fail'              => UpdateFail::class
        ], 'show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($user, 'index');
    }
}
