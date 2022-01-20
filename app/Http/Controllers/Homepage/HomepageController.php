<?php

namespace App\Http\Controllers\Homepage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageController extends Controller {
    public function mostraHomepage() {
        if (Auth::check()) {
            $utilizador=Auth::user()->nome_utilizador;
            if(Auth::user()->banido!=null){
                return(redirect()->route('perfil-apelos',[$utilizador]));
            }
        } 
        return (Auth::check() ? redirect()->route('para-si') : redirect()->route('tendencias'));
    }
}
