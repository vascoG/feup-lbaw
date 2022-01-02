<?php

namespace App\Http\Controllers\Homepage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParaSiController extends Controller {
    public function mostraParaSi() {
        return view('teste', [
            'selecionado' => 'para-si'
        ]);
    }
}
