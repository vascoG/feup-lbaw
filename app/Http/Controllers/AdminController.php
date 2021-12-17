<?php

namespace App\Http\Controllers;
use App\Models\ApeloDesbloqueio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showModerador()
    {
        if(!Auth::check()) return redirect('/login');
        $this->authorize('admin');
        return $user->toJson();

    }
}