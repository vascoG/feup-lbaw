<?php

namespace App\Http\Controllers\Auth;

use App\Models\Utilizador;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegistoController extends Controller {
    use RegistersUsers;

    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function validator(array $data) {
        return Validator::make($data, [
            'nome_utilizador' => 'required|string|max:256',
            'nome' => 'required|string|max:512',
            'data_nascimento' => 'required|string',
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
            'palavra_passe' => bcrypt($data['password']),
            //TODO: Perguntar ao professor qual o valor a colocar aqui
            //TODO: Colocar imagem perfil default
            'moderador' => false,
            'administrador' => false,
        ]);
    }

}
