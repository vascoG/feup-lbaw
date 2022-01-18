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
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Contracts\Auth\CanResetPassword;

class Utilizador extends Authenticable implements CanResetPassword{
    use Notifiable;

    public static $imagemPadrao = 'storage/avatar-default.png';

    public static $nomePadrao = '[Apagado]';

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

    protected static function booted() {
        static::deleted(function ($utilizador) {
            foreach($utilizador->notificacoesRelacionadas() as $notificacao) {
                $notificacao->delete();
            }
        });
    }

    public function notificacoesRelacionadas() {
        $votoResposta = DatabaseNotification::query()
            ->where('type', 'App\Notifications\VotoRespostaNotification')
            ->where('data->idAutorVoto', $this->id)
            ->get();
        $votoQuestao = DatabaseNotification::query()
            ->where('type', 'App\Notifications\VotoQuestaoNotification')
            ->where('data->idAutorVoto', $this->id)
            ->get();
        $respostaQuestao = DatabaseNotification::query()
            ->where('type', 'App\Notifications\RespostaQuestaoNotification')
            ->where('data->idAutorResposta', $this->id)
            ->get();
        return $votoQuestao->concat($votoResposta)->concat($respostaQuestao);
    }

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
}