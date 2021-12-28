<?php

namespace App\Policies;


use App\Models\Utilizador;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AdminPolicy{

    use HandlesAuthorization;

    public function admin(){
        $admin = Utilizador::find();
    }

}