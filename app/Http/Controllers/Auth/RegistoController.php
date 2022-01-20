<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Utilizador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegistoController extends Controller {
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'nome_utilizador' => 'required|string|max:256|unique:utilizador|regex:/^[a-z](?:-?[a-z0-9])*$/',
            'nome' => 'required|string|max:512',
            'data_nascimento' => 'date|required|string|date_format:Y-m-d|before_or_equal:'.Carbon::parse(Carbon::now())->format('Y-m-d'),
            'e_mail' => 'required|string|email|max:512|unique:utilizador',
            'palavra_passe' => 'required|string|min:8|confirmed',
        ]);
    }

    public function showRegistrationForm() {
        return view('auth.registo');
    }

    protected function create(array $data) {
        return Utilizador::create([
            'nome_utilizador' => $data['nome_utilizador'],
            'nome' => $data['nome'],
            'e_mail' => $data['e_mail'],
            'palavra_passe' => Hash::make($data['palavra_passe']),
            'data_nascimento' => $data['data_nascimento']
        ]);
    }

}
