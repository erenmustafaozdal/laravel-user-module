<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo;

    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->subject = trans('laravel-user-module::auth.mail_subject');
        $this->redirectTo = config('laravel-user-module.redirect_route');
    }

    /**
     * get forget password metod
     *
     * @return View
     */
    public function getForgetPassword()
    {
        return view(config('laravel-user-module.views.forget_password'));
    }

    /**
     * post forget password metod
     *
     * @param   Request     $request
     */
    public function postForgetPassword(Request $request)
    {
        //
    }

    /**
     * get reset password metod
     *
     * @param   string      $token
     * @return  View
     */
    public function getResetPassword($token)
    {
        return view(config('laravel-user-module.views.reset_password'),compact('token'));
    }

    /**
     * post reset password metod
     *
     * @param   Request     $request
     */
    public function postResetPassword(Request $request)
    {
        //
    }
}
