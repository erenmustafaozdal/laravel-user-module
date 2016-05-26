<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Yajra\Datatables\Facades\Datatables;

class UserApiController extends Controller
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

        return Datatables::of($users)
            ->addColumn('urls', function($model)
            {
                return [
                    'details'   => route('api.user.detail', ['id' => $model->id]),
                    'fast_edit' => route('api.user.fast_edit', ['id' => $model->id]),
                    'show'      => route('admin.user.show', ['id' => $model->id]),
                    'edit'      => route('api.user.update', ['id' => $model->id]),
                    'destroy'   => route('api.user.destroy', ['id' => $model->id]),
                ];
            })
            ->addColumn('check_id', '{{ $id }}')
            ->addColumn('status',function($model)
            {
                return $model->is_active;
            })
            ->editColumn('photo',function($model)
            {
                return $model->getPhoto([], 'thumbnail', true);
            })
            ->editColumn('first_name',function($model)
            {
                return $model->fullname;
            })
            ->editColumn('created_at',function($model)
            {
                return $model->created_at_table;
            })
            ->removeColumn('is_active')
            ->make(true);
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
        return Datatables::of($user)
            ->editColumn('roles', function($model)
            {
                return $model->roles->implode('name', ', ');
            })
            ->editColumn('last_login',function($model)
            {
                return $model->last_login_table;
            })
            ->editColumn('updated_at',function($model)
            {
                return $model->updated_at_table;
            })
            ->make(true);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
