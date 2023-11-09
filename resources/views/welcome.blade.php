@extends('layouts.main')

@section('title', 'HDC Events')

@section('content')

    {{-- Estrutura do banner principal;
                           class do bootstrapi pra preencher a tela toda com 12 colunas --}}
    <div id="search-container" class="col-md-12">
        <h1>Busque um evento</h1>
        <form action="/" method="GET">
            {{-- id pra estilizar ele; name pra pegar o conteúdo do formulário no back-end;
            class do próprio bootstrapi pra deixar o input estilizado corretamente e placeholder pra
            dar uma dica ao usuário, do que ele tem que preencher --}}

            <div class="input-group">
                <input type="text" id="search" name="search" class="form-control" placeholder="Procurar...">
                {{-- classe para que o botão apareça ao lado do input --}}
                <div class="input-group-append">
                    <button type="submit" class="btn search">
                        <ion-icon name="search"></ion-icon>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- corpo do site, lista de eventos --}}
    <div id="events-container" class="col-md-12">
        @if ($search)
        <h2>Buscando por: {{ $search }}</h2>
        @else
        <h2>Próximos Eventos</h2>
        {{-- Usado a class no css para estilização --}}
        <p class="subtitle">Veja os eventos dos próximos dias</p>
        @endif
        {{-- container que abriga a lista de eventos do site; class do bootstrapi tbm --}}
        <div id="cards-container" class="row">
            @foreach ($events as $event)
                <div class="card col-md-3">
                    {{-- no alt temos o atributo que vem do banco de dados --}}
                    <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}">
                    <div class="card-body">
                        {{-- Inserir a diretiva de variáveis '{{  }}' pra ficar no formato BR com funções do php, colocando a função date com o padrão que queremos --}}
                        <p class="card-date">{{ date('d/m/Y', strtotime($event->date)) }}</p>
                        <h5 class="card-title">{{ $event->title }}</h5>
                        <p class="card-participants">{{ count($event->users) }} Participantes</p>
                        <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber mais</a>
                    </div>
                </div>
            @endforeach
            @if (count($events) == 0 && $search)
            <p>Não foi possível encontrar nenhum evento com {{ $search }}!<a href="/">  Ver todos</a></p>
            @elseif(count($events) == 0)
            <p>Não há eventos disponíveis</p>
            @endif
        </div>
    </div>

@endsection
