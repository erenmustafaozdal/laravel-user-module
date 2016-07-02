<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\User;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
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

class UserController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(Sentinel::getUser());
        return view(config('laravel-user-module.views.user.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize(Sentinel::getUser());
        return view(config('laravel-user-module.views.user.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize(Sentinel::getUser());
        return $this->storeModel(User::class, $request, [
            'success'           => StoreSuccess::class,
            'fail'              => StoreFail::class,
            'activationSuccess' => ActivateSuccess::class,
            'activationFail'    => ActivateFail::class
        ], config('laravel-user-module.user.uploads'), 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize($user);
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
        $this->authorize($user);
        return view(config('laravel-user-module.views.user.edit'), compact('user'));
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
        $this->authorize($user);
        $result = $this->updateModel($user, $request,  [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], config('laravel-user-module.user.uploads'), 'show');

        // activation
        $request->has('is_active') ? $this->activationComplete($this->model, [
            'activationSuccess'     => ActivateSuccess::class,
            'activationFail'        => ActivateFail::class
        ]) : $this->activationRemove($this->model, [
            'activationRemove'      => ActivateRemove::class,
            'activationFail'        => ActivateFail::class
        ]);
        return $result;
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
        $this->authorize($user);
        return $this->updateModel($user,$request,  [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], [], 'show');
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
        $this->authorize($user);
        return $this->updateModel($user,$request,  [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], [], 'show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize($user);
        return $this->destroyModel($user, [
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ], 'index');
    }
}
