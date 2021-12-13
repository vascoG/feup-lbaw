<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApeloDesbloqueio extends Model {
    public $timestamp = false;

    public $table = 'utilizador_banido';

    protected $fillable = ['motivo', 'id_utilizador'];

    function utilizador() {
        return $this->hasOne('App\Models\UtilizadorBanido', 'id_utilizador', 'id');
    }
}