<?php

namespace ErenMustafaOzdal\LaravelUserModule\Http\Composers;

use Illuminate\Contracts\View\View;
use Sentinel;
use App\FastMenu;

class AdminComposer
{
    /**
     * The user repository implementation.
     *
     * @var \Cartalyst\Sentinel\Users\EloquentUser
     */
    protected $auth_user;

    /**
     * fast menus
     *
     * @var \Illuminate\Support\Collection
     */
    protected $fastMenus;

    /**
     * Create a new profile composer
     */
    public function __construct()
    {
        $this->auth_user = Sentinel::getUser();
        $this->fastMenus = FastMenu::all();
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
        $view->with('fastMenus', $this->fastMenus);
    }
}