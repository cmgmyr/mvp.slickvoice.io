<?php

namespace Sv\Http\Composers;

use Illuminate\Contracts\Auth\Guard as Auth;
use Illuminate\Contracts\View\View;

class AppComposer
{
    /**
     * @var Auth
     */
    private $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Pushes custom data to the view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $user = $this->auth->user();
        $view->with('currentUser', $user);

        $admin = false;
        if ($user) {
            $admin = $user->admin;
        }
        $view->with('isAdmin', $admin);
    }
}
