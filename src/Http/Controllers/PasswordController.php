<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Laracasts\Flash\Flash;
use Mail;

// requests
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Auth\ForgetPasswordRequest;
use ErenMustafaOzdal\LaravelUserModule\Http\Requests\Auth\ResetPasswordRequest;
// events
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\PasswordResetMailSend;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ForgetPasswordFail;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ResetPasswordSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ResetPasswordUserNotFound;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\ResetPasswordIncorrectCode;
// exceptions
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\ForgetPasswordException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\ResetPasswordUserNotFoundException;
use ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth\ResetPasswordIncorrectCodeException;

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
        $this->subject = lmcTrans('laravel-user-module/auth.forget_password.mail_subject');
        $this->redirectTo = config('laravel-user-module.redirect_route');
    }

    /**
     * get forget password metod
     *
     * @return View
     */
    public function getForgetPassword()
    {
        return view(config('laravel-user-module.views.auth.forget_password'));
    }

    /**
     * post forget password metod
     *
     * @param   ForgetPasswordRequest     $request
     * @return  Redirector
     * @throw   ForgetPasswordException
     */
    public function postForgetPassword(ForgetPasswordRequest $request)
    {
        try {
            $user = Sentinel::findByCredentials([ 'login' => $request->input('email')]);
            if ( is_null($user) ) {
                throw new ForgetPasswordException($request->all());
            }

            $datas = [
                'user'          => $user,
                'reminder'      => Reminder::create($user)
            ];
            $subject = $this->subject;
            Mail::queue(config('laravel-user-module.views.email.forget_password'), $datas, function($message) use($user,$subject) {
                $message->to($user->email, $user->fullname)
                    ->subject($subject);
            });
            // event fire
            event(new PasswordResetMailSend($request->all()));
            Flash::success(trans('laravel-user-module::auth.forget_password.success', [
                'name'  => $user->first_name,
                'email' => $user->email
            ]));
            return redirect(lmbRoute('getLogin'));
        } catch (ForgetPasswordException $e) {
            Flash::error(trans('laravel-user-module::auth.forget_password.fail', [ 'email' => $request->input('email') ]));
            // event fire
            event(new ForgetPasswordFail($e->getDatas()));
            return redirect(lmbRoute('getForgetPassword'))->withInput();
        }
    }

    /**
     * get reset password metod
     *
     * @param   string      $token
     * @return  View
     * @throw   NotFoundHttpException
     */
    public function getResetPassword($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }
        return view(config('laravel-user-module.views.auth.reset_password'),compact('token'));
    }

    /**
     * post reset password metod
     *
     * @param   ResetPasswordRequest     $request
     * @return  Redirector
     * @throw   ResetPasswordException
     */
    public function postResetPassword(ResetPasswordRequest $request)
    {
        try {
            $user = Sentinel::findByCredentials([ 'login' => $request->input('email')]);
            if ( is_null($user) ) {
                throw new ResetPasswordUserNotFoundException($request->all());
            }
            if ( ! Reminder::complete($user, $request->input('token'), $request->input('password')) ) {
                throw new ResetPasswordIncorrectCodeException($request->all());
            }
            Flash::success(trans('laravel-user-module::auth.reset_password.success', [ 'email' => $request->input('email') ]));
            // event fire
            event(new ResetPasswordSuccess($user));
            return redirect(lmbRoute('getLogin'));
        } catch (ResetPasswordUserNotFoundException $e) {
            Flash::error(trans('laravel-user-module::auth.reset_password.user_not_found', [ 'email' => $request->input('email') ]));
            // event fire
            event(new ResetPasswordUserNotFound($e->getDatas()));
            return redirect(lmbRoute('getResetPassword', ['token' => $request->input('token')]))->withInput();
        } catch (ResetPasswordIncorrectCodeException $e) {
            Flash::error(trans('laravel-user-module::auth.reset_password.incorrect_code'));
            // event fire
            event(new ResetPasswordIncorrectCode($user));
            return redirect(lmbRoute('getForgetPassword'))->withInput();
        }
    }
}
