<?php

namespace App\Models;

use App\Models\UtilizadorAtivo;
use App\Models\UtilizadorBanido;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperaConta;
use Illuminate\Contracts\Auth\CanResetPassword;

class Utilizador extends Authenticable implements CanResetPassword{
    use Notifiable;

    private static $imagemPadrao = 'storage/avatar-default.png';

    public $timestamps = false;

    protected $table = 'utilizador';
    
    protected $fillable = [
        'imagem_perfil',
        'nome_utilizador',
        'nome',
        'e_mail',
        'data_nascimento',
        'descricao',
        'palavra_passe'
    ];

    protected $attributes = [
        'moderador' => false,
        'administrador' => false,
    ];

    protected $hidden = [
        'palavra_passe', 'imagem_perfil'
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

    public function getImagemPerfilAttribute($value) {
        if (is_null($value)) {
            return self::$imagemPadrao;
        }
        return $value;
    }

    public function getEmailForPasswordReset() {
        return $this->e_mail;
    }

    public function sendPasswordResetNotification($token) {
        Mail::to($this->e_mail)->send(new RecuperaConta($this, $token));
    }

    public static function apagado() {
        $utilizador = collect(new Utilizador);
        $utilizador->nome_utilizador = '[apagado]';
        $utilizador->nome = '[apagado]';
        $utilizador->imagem_perfil = self::$imagemPadrao;
        return $utilizador;
    }
}