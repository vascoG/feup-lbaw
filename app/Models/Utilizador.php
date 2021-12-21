<?php

namespace App\Models;

use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Collection;

class Utilizador extends Authenticable {
    public $timestamps = false;

    protected $table = 'utilizador';
    
    protected $fillable = [
        'imagem_perfil', 'nome_utilizador', 'nome', 'e_mail', 'data_nascimento', 'palavra_passe'
    ];

    protected $attributes = [
        'moderador' => false,
        'administrador' => false,
    ];

    protected $hidden = [
        'palavra_passe', 'imagem_perfil'
    ];

    protected $dates = [
        'data_nascimento',
    ];

    public function getAuthPassword() {
        return $this->palavra_passe;
    }

    public function ativo() {
        return $this->hasOne('App\Models\UtilizadorAtivo', 'id_utilizador', 'id');
    }

    public function banido() {
        return $this->hasOne('App\Models\UtilizadorBanido', 'id_utilizador', 'id');
    }

    public static function procuraNomeUtilizador(String $nomeUtilizador) {
        $colecao = Utilizador::where('nome_utilizador', $nomeUtilizador)->get();
        return ($colecao->isEmpty() ? null : $colecao->first());
    }
}