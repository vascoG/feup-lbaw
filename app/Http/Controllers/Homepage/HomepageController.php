<?php

namespace App\Http\Controllers\Homepage;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomepageController extends Controller {
    public function mostraHomepage() {
        return (Auth::check() ? redirect()->route('para-si') : redirect()->route('tendencias'));
    }
}
