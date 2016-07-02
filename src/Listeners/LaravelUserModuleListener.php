<?php

namespace ErenMustafaOzdal\LaravelUserModule\Listeners;

use Illuminate\Http\Request;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\RegisterSuccess;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\SentinelNotActivated;
use ErenMustafaOzdal\LaravelUserModule\Events\Auth\SentinelThrottling;
use Mail;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Laracasts\Flash\Flash;

class LaravelUserModuleListener
{
    protected $request;

    /**
     * Create the event handler.
     *
     * @param Request $request
     * @return mixed
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen('ErenMustafaOzdal\LaravelUserModule\Events\Auth\RegisterSuccess', 'ErenMustafaOzdal\LaravelUserModule\\Listeners\LaravelUserModuleListener@sendActivationMail');
        $events->listen('ErenMustafaOzdal\LaravelUserModule\Events\Auth\SentinelNotActivated', 'ErenMustafaOzdal\LaravelUserModule\\Listeners\LaravelUserModuleListener@notActivatedFlashMessage');
        $events->listen('ErenMustafaOzdal\LaravelUserModule\Events\Auth\SentinelThrottling', 'ErenMustafaOzdal\LaravelUserModule\\Listeners\LaravelUserModuleListener@throttlingFlashMessage');
    }

    /**
     * send activation mail metod
     *
     * @param   RegisterSuccess     $event
     * @return  void
     */
    public function sendActivationMail($event)
    {
        $email = $event->user->email;
        $name = $event->user->fullname;
        $datas = [
            'user'          => $event->user,
            'activation'    => Activation::create($event->user)
        ];
        Mail::queue(config('laravel-user-module.views.email.activation'), $datas, function($message) use($email,$name) {
            $message->to($email, $name)
                ->subject(lmcTrans('laravel-user-module/auth.activation.mail_subject'));
        });
    }
    /**
     * handle user throttlingFlashMessage
     *
     * @param 	SentinelThrottling 		$event
     **/
    public function throttlingFlashMessage(SentinelThrottling $event)
    {
        $free = Carbon::parse($event->e->getFree())->format(config('laravel-user-module.date_format'));

        $message = str_replace(':date',$free,trans('laravel-user-module::auth.login.exception.throttling.'.$event->e->getType()));

        Flash::error($message);
    }

    /**
     * handle user notActivatedFlashMessage
     *
     * @param 	SentinelNotActivated 		$event
     **/
    public function notActivatedFlashMessage(SentinelNotActivated $event)
    {
        Flash::error(trans('laravel-user-module::auth.login.exception.not_activate'));
    }
}