<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticable;

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
}