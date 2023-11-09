@extends('layouts.main')

@section('title', 'Editando: ' . $event->title)

@section('content')

{{-- Container de formulário, jogando para o centro da tela com apenas 6 colunas --}}
<div id="event-create-container" class="col-md-6 offset-md-3">
  <h1>Editando: {{ $event->title }}</h1>
  {{-- adicionamos um POST para a rota update (de atualizar dados) | enctype necessário para enviar anviar arquivos pelo formulário--}}
  <form action="/events/update/{{ $event->id }}" method="POST" enctype="multipart/form-data">
    {{-- diretiva do blade para conseguir enviar o formulário, pois o Laravel tem uma proteção de csrf para ataques a formulário --}}
    @csrf
    @method('PUT') {{--  PUT => UPDATE no Laravel --}}
    {{-- os value foram adicionados pra mostrar o valor da variável do evento em questão --}}
    <div class="form-group">
        <label for="image">Imagem do Evento:</label>
        <input type="file" id="image" name="image" class="from-control-file">
        <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}" class="img-preview">
      </div>
    <div class="form-group">
      <label for="title">Evento:</label>
      <input type="text" class="form-control" id="title" name="title" placeholder="Nome do evento" value="{{ $event->title }}">
    </div>
    <div class="form-group">
        <label for="date">Data do evento:</label>
        <input type="date" class="form-control" id="date" name="date" value="{{ $event->date->format('Y-m-d') }}">
      </div>
    <div class="form-group">
      <label for="title">Cidade:</label>
      <input type="text" class="form-control" id="city" name="city" placeholder="Local do evento" value="{{ $event->city }}">
    </div>
    <div class="form-group">
      <label for="title">O evento é privado?</label>
      <select name="private" id="private" class="form-control">
        <option value="0">Não</option>
        <option value="1" {{ $event->private == 1 ? "selected='selected'" : "" }}>Sim</option>
        {{-- pra mostrar se o evento é privado vamos ter um if ternário pra verificar se tá com o valor default '0' ou não --}}
      </select>
    </div>
    <div class="form-group">
      <label for="title">Descrição:</label>
      {{-- Não é input e sim textarea poqrque pode ser um texto grande --}}
      <textarea name="description" id="description" class="form-control" placeholder="O que vai acontecer no evento?">{{ $event->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="title">Adicione itens de infraestrutura:</label>
        <div class="form-group">
            {{-- Precisamos das chaves [] no name por ser um 'array' de itens, um ou mais itens --}}
            <input type="checkbox" name="items[]" value="Cadeiras"> Cadeiras
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Palco"> Palco
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Cerveja Grátis"> Cerveja Grátis
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Open Food"> Open Food
        </div>
        <div class="form-group">
            <input type="checkbox" name="items[]" value="Brindes"> Brindes
        </div>
    </div>
    <input type="submit" class="btn btn-primary" value="Editar Evento">
  </form>
</div>

@endsection
