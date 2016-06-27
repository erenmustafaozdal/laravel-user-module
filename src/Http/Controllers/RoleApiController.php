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


class RoleApiController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $roles = Role::select(['id','name','slug','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $roles->filter($request);
        }

        $addColumns = [
            'addUrls' => [
                'edit_page'     => ['route' => 'admin.role.edit', 'id' => true]
            ]
        ];
        $editColumns = [
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = [];
        return $this->getDatatables($roles, $addColumns, $editColumns, $removeColumns);
    }

    /**
     * get detail
     *
     * @param integer $id
     * @param Request $request
     * @return Datatables
     */
    public function detail($id, Request $request)
    {
        $user = Role::where('id',$id)->select(['id','name','slug', 'created_at','updated_at']);

        $editColumns = [
            'created_at'    => function($model) { return $model->created_at_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        return $this->getDatatables($user, [], $editColumns, []);
    }

    /**
     * get model data for edit
     *
     * @param Role $role
     * @param Request $request
     * @return Datatables
     */
    public function fastEdit(Role $role, Request $request)
    {
        return $role;
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
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Role $role
     * @param  UpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Role $role)
    {
        return $this->updateModel($role, $request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        return $this->destroyModel($role, [
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        if ( $this->destroyGroupAction(Role::class, $request->input('id'), []) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }
}
