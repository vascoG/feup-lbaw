@component('mail::message')
Bom dia,

Esta mensagem está a ser enviada na sequencia de um pedido de recuperação de conta.
Se não conhece os nossos serviços, ou não está registado ignore a mensagem.

@component('mail::button', ['url' => route('altera-password', $token)])
Recuperar Conta
@endcomponent

Obrigado por confiar em nós,<br>
{{ config('app.name') }}
@endcomponent
