<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resposta extends Model {
    public $timestamp = false;

    public $table = 'resposta';

    protected $fillable = ['texto', 'autor', 'id_questao', 'resposta_aceite'];

    function autor() {
        return $this->hasOne('App\Model\UtilizadorAtivo', 'autor', 'id');
    }

    function questao() {
        return $this->hasOne('App\Model\Questao', 'id_questao', 'id');
    }
}