<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApeloDesbloqueio extends Model {
    public $timestamp = false;

    public $table = 'apelo_desbloqueio';

    protected $fillable = ['motivo', 'id_utilizador'];
}