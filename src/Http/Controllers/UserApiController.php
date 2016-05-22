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
            ->addColumn('details_url', function($model)
            {
                return route('api.user.index.detail', ['id' => $model->id]);
            })
            ->addColumn('check_id', '{{ $id }}')
            ->editColumn('photo',function($model)
            {
                return $model->getPhoto([], 'thumbnail', true);
            })
            ->editColumn('first_name',function($model)
            {
                return $model->fullname;
            })
            ->addColumn('status',function($model)
            {
                return $model->is_active;
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
     * @param  Request  $request
     * @param  integer  $id
     * @return Datatables
     */
    public function getUserDetail(Request $request, $id)
    {
        return $id;
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
