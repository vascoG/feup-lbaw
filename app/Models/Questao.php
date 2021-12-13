<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Questao extends Model {
    public $timestamp = false;

    public $table = 'questao';

    protected $fillable = ['texto', 'autor', 'titulo'];

    function autor() {
        return $this->hasOne('App\Model\UtilizadorAtivo', 'autor', 'id');
    }
}