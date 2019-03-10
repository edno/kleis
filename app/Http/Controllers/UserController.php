<?php

namespace App\Http\Controllers;

use Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showProfile()
    {
        $controller = new AdminController();
        return $controller->editUser(Auth::user()->id);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->intended('login');
    }
}
