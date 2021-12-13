<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model {
    public $timestamp = false;

    public $table = 'comentario';

    protected $fillable = ['texto', 'autor', 'id_questao', 'id_resposta'];

    function autor() {
        return $this->hasOne('App\Model\UtilizadorAtivo', 'autor', 'id');
    }

    function questao() {
        return $this->hasOne('App\Model\Questao', 'id_questao', 'id');
    }

    function resposta() {
        return $this->hasOne('App\Model\Resposta', 'id_resposta', 'id');
    }
}