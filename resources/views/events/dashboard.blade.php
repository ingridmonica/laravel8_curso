@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Meus Eventos</h1>
</div>

 {{-- Exibir os evento efuturamente vai ter um arelação de Many to Many e permitir sair doevento, não perticipar mais --}}
<div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($events) > 0)
    <table class="table">
        {{-- pra colocar as colunas --}}
        <thead>
            {{--  table row | no th atributo de scope col => coluna da tabela--}}
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Participantes</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
                <tr>
                    {{-- atributo de scropt row => linha  da tabela | tem acesso a variável loop do blade e o index de acesso + 1 (sempre somando um ao indexx pra o index não ser 0)--}}
                    <td scropt="row">{{ $loop->index +1 }}</td>
                    <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
                    <td>{{ count($event->users) }}</td>
                    <td>
                        <a href="/events/edit/{{ $event->id }}" class="btn btn-info edit-btn"><ion-icon name="create-outline"></ion-icon>Editar</a>
                        <form action="/events/{{ $event->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-btn"><ion-icon name="trash-outline"></ion-icon>Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>Você ainda não tem eventos, <a href="/events/create">criar evento</a></p>
    @endif
</div>

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Eventos que estou participando</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-events-container">
@if(count($eventsasparticipant)> 0)
<table class="table">
    {{-- pra colocar as colunas --}}
    <thead>
        {{--  table row | no th atributo de scope col => coluna da tabela--}}
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nome</th>
            <th scope="col">Participantes</th>
            <th scope="col">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($eventsasparticipant as $event)
            <tr>
                {{-- atributo de scropt row => linha  da tabela | tem acesso a variável loop do blade e o index de acesso + 1 (sempre somando um ao indexx pra o index não ser 0)--}}
                <td scropt="row">{{ $loop->index +1 }}</td>
                <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
                <td>{{ count($event->users) }}</td>
                <td>
                   <form action="/events/leave/{{ $event->id }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <button type="submit" class="btn btn-danger delete-btn">
                            <ion-icon name="trash-outline"></ion-icon>Sair do evento
                        </button>
                   </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<p>Você ainda não está participando de um evento, <a href="/">veja todos os eventos</a></p>
@endif
</div>
@endsection
