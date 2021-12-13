<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilizadorAtivo extends Model {
    public $timestamp = false;

    public $table = 'utilizador_autenticado';

    protected $fillable = ['id_utilizador'];

    function utilizador() {
        return $this->hasOne('App\Models\Utilizador', 'id_utilizador', 'id');
    }
}
