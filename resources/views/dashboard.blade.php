@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus Eventos</h1>
</div>

 {{-- Exibir os evento efuturamente vai ter um arelação de Many to Many e permitir sair doevento, não perticipar mais --}}
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($events) > 0)
    @else
    <p>Você ainda não tem eventos, <a href="/events/create">criar eveto</a></p>
    @endif
</div>

@endsection
