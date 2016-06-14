<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
use ErenMustafaOzdal\LaravelModulesBase\Repositories\ImageRepository;
// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\StoreRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\UpdateRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\User\PhotoRequest;

class UserController extends AdminBaseController
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        //
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
     * @param  UpdateRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, User $user)
    {
        return $this->updateModel($user,$request,false,'show');
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

    /**
     * uploaded temp photo for this user
     *
     * @param ImageRepository $image
     * @param PhotoRequest $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function tempPhoto(ImageRepository $image, PhotoRequest $request, User $user)
    {
        return $image->uploadPhoto($user, $request, config('laravel-user-module.user.uploads'), true);
    }
}
