<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Role;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\Role\StoreSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\StoreFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\UpdateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\UpdateFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\DestroySuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Role\DestroyFail;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Role\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Role\UpdateRequest;

class RoleController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize(Role::take(1)->get()[0]);
        return view(config('laravel-user-module.views.role.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize(Role::take(1)->get()[0]);
        return view(config('laravel-user-module.views.role.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->authorize(Role::take(1)->get()[0]);
        return $this->storeModel(Sentinel::getRoleRepository()->createModel(), $request, [
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ], [], 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize($role);
        return view(config('laravel-user-module.views.role.show'), compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize($role);
        return view(config('laravel-user-module.views.role.edit'), compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        $this->authorize($role);
        return $this->updateModel($role,$request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], [],'show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->authorize($role);
        return $this->destroyModel($role, [
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ], 'index');
    }
}
