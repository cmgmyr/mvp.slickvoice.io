<?php

namespace Sv\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Sv\Notifications\Flash;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Redirects to specified route with a successful message.
     *
     * @param $route
     * @param $message
     * @param array $params
     * @return mixed
     */
    public function redirectRouteWithSuccess($route, $message, $params = [])
    {
        Flash::success($message);

        return redirect()->route($route, $params);
    }

    /**
     * * Redirects to specified route with an error message.
     *
     * @param $route
     * @param $message
     * @param array $params
     * @return mixed
     */
    public function redirectRouteWithError($route, $message, $params = [])
    {
        Flash::error($message);

        return redirect()->route($route, $params);
    }

    /**
     * Redirects back with a successful message.
     *
     * @param $message
     * @return mixed
     */
    public function redirectBackWithSuccess($message)
    {
        Flash::success($message);

        return redirect()->back();
    }

    /**
     * Redirects back with an error message.
     *
     * @param $message
     * @return mixed
     */
    public function redirectBackWithError($message)
    {
        Flash::error($message);

        return redirect()->back();
    }
}
