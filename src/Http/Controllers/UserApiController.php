<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\User;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\UpdateRequest;


class UserApiController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $users = User::select(['id','photo','first_name','last_name', 'is_active','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $users->filter($request);
        }

        $addColumns = [
            'addUrls' => [
                'activate'      => ['route' => 'api.user.activate', 'id' => true],
                'not_activate'  => ['route' => 'api.user.not_activate', 'id' => true]
            ],
            'status'            => function($model) { return $model->is_active; },
            'fullname'          => function($model) { return $model->fullname; },
        ];
        $editColumns = [
            'photo'             => function($model) { return $model->getPhoto([], 'thumbnail', true); },
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = ['is_active', 'first_name', 'last_name'];
        return $this->getDatatables($users, $addColumns, $editColumns, $removeColumns);
    }

    /**
     * get user detail
     *
     * @param integer $id
     * @param Request $request
     * @return Datatables
     */
    public function userDetail($id, Request $request)
    {
        $user = User::where('id',$id)->with('roles')->select(['id','email','last_login','updated_at']);

        $editColumns = [
            'roles'         => function($model) { return $model->roles->implode('name', ', '); },
            'last_login'    => function($model) { return $model->last_login_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        $removeColumns = ['is_active', 'first_name', 'last_name'];
        return $this->getDatatables($user, [], $editColumns, $removeColumns);
    }

    /**
     * get user data for edit
     *
     * @param User $user
     * @param Request $request
     * @return Datatables
     */
    public function userForFastEdit(User $user, Request $request)
    {
        return $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->storeModel(User::class, $request);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param  UpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        return $this->updateModel($user, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id != Sentinel::getUser()->id) {
            return $this->destroyModel($user);
        } else {
            return response()->json(['result' => 'self']);
        }
    }

    /**
     * activate user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        if ($this->activationComplete($user)) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * not activate user
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function notActivate(User $user)
    {
        if ($this->activationRemove($user)) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function groupAction(Request $request)
    {
        $action = camel_case($request->input('action')) . 'GroupAction';
        if ( $this->$action(User::class, $request->input('id')) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }
}
