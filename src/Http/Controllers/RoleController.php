<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

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
        return view(config('laravel-user-module.views.role.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        return $this->storeModel(Sentinel::getRoleRepository()->createModel(), $request, [
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ], [], 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view(config('laravel-user-module.views.role.show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
