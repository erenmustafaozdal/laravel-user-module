<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Composers;

use Illuminate\Contracts\View\View;
use Sentinel;

class AdminComposer
{
    /**
     * The user repository implementation.
     *
     * @var \Cartalyst\Sentinel\Users\EloquentUser
     */
    protected $auth_user;

    /**
     * Create a new profile composer
     */
    public function __construct()
    {
        $this->auth_user = Sentinel::getUser();
    }

    /**
     * Bind data to the view.
     *
     * @param   View        $view
     * @return  void
     */
    public function compose(View $view)
    {
        $view->with('auth_user', $this->auth_user);
    }
}