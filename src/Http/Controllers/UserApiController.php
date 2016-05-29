<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use DB;
use App\User;

// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\UpdateRequest;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\User\StoreSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\StoreFail;
use ErenMustafaOzdal\LaravelUserModule\Events\User\UpdateSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\User\UpdateFail;
// exceptions
use ErenMustafaOzdal\LaravelUserModule\Exceptions\StoreException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\UpdateException;


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

        return Datatables::of($users->orderBy('id', 'desc'))
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
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $datas = $request->all();
        $datas['is_active'] = $request->has('is_active');

        DB::beginTransaction();
        try {
            $user = Sentinel::create($datas);

            if ( ! isset($user->id)) {
                throw new StoreException($datas);
            }

            event(new StoreSuccess($user));
            DB::commit();
            return response()->json(['result' => 'success']);
        } catch (StoreException $e) {
            DB::rollback();
            event(new StoreFail($e->getDatas()));
            return response()->json(['result' => 'error']);
        }
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
        $datas = collect( $request->except('email') );
        $datas = $datas->reject(function($item)
        {
            return $item === '';
        })->toArray();
        
        DB::beginTransaction();
        try {
            $user_new = Sentinel::update($user, $datas);

            if ( ! isset($user_new->id)) {
                throw new UpdateException($user);
            }

            event(new UpdateSuccess($user_new));
            DB::commit();
            return response()->json(['result' => 'success']);
        } catch (UpdateException $e) {
            DB::rollback();
            event(new UpdateFail($e->getDatas()));
            return response()->json(['result' => 'error']);
        }
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
