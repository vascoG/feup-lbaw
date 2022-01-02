@extends('layouts.homepage')

@section('homepage-conteudo')
@include('partials.cards.home.etiqueta', [
    'etiqueta' => App\Models\Etiqueta::find(1)
])
@endsection