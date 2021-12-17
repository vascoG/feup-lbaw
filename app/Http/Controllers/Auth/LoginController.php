<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request){
        return $request->only($this->username(), 'palavra_passe');
    }

    protected function validateLogin(Request $request) {
        $request->validate([
            $this->username() => 'required|string',
            'palavra_passe' => 'required|string',
        ]);
    }

    public function username() {
        return 'e_mail';
    }
}