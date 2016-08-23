<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use App\Http\Requests;
use Sentinel;
use App\Role;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseController;
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

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('laravel-user-module.views.role.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $operation = 'create';
        return view(config('laravel-user-module.views.role.create'), compact('operation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $this->setEvents([
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
        return $this->storeModel(Sentinel::getRoleRepository()->createModel(), 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
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
        $operation = 'edit';
        return view(config('laravel-user-module.views.role.edit'), compact('role','operation'));
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
        $this->setEvents([
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
        return $this->updateModel($role,'show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($role, 'index');
    }
}
