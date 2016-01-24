<?php

namespace Sv\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application welcome page or dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            return view('home');
        }

        return view('welcome');
    }

    public function soon()
    {
        return view('soon');
    }
}
