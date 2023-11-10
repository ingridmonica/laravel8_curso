<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Chamar o Model do Event para o Controller pra ter acesso a ele
use App\Models\Event;
// Usar o model do user pra poder puxar o usuário dono do evento
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;

class EventController extends Controller
{
    // index action = / da aplicação => rota principal
    public function index () {

        $search = request('search');

        if($search) {
            // lógica da busca
            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
            // o get() dizque queremos pegar esse registro


        } else {
            // all => método ORM que pega todos os registros do banco
            $events = Event::all();
        }

        // Passamos lá no template
        return view('welcome',['events' => $events, 'search' => $search]);
    }

    // Nome padrão pra quando estamos criando um dado (GET do formulário)
    public function create() {
        return view('events.create');
    }

    // Request vai trazer todos os dados enviados pelo formulário
    // action pra tratar os dados recebidos pelo form e salvar no banco de dados
    public function store(Request $request){

        // cria varável e estancia(uma nova classe) a classe do Model
        $event = new Event;

        // preenche os dados que precisam serem preenchidos no banco
        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;   // items como outra propriedade para receber os itens do front para o banco, e precisamos alterar o Model para ser recebido como array e não ocmo string

        // Image Upload
        // Se o request possui uma imagem e essa imagem é válida, faz o processamento dos dados
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;
            $extension = $requestImage->extension();

            // Cria uma string única baseado no tempo que ta dando upload e é colocado no md5 pra fazer uma hash
            // pego o nome do arquivo, acesso a propriedade imgae e o método getClientOriginalName() concatenado com o tempo de agora e com a extensão do arquivo
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now") . "." . $extension);

            // Salvando a imagem no servidor na pasta events com o nome em hash
            $requestImage->move(public_path('img/events'), $imageName);

            // Salva no banco de fato
            $event->image = $imageName;

        }

        // inserção do user_id na tabela events quando for enviado um formulário de create. Pega o usuário logado com o método auth()
        // acessando a propriedade 'id' do usuário logado
        $user = auth()->user();
        $event->user_id = $user->id;

        // salvar os dados no banco para persistir, com o método save()
        $event->save();

        // usa o método with() pra enviar um texto(mensagem) com uma chave 'msg'
        return redirect('/')->with('msg', 'Evento criado com sucesso!');

    }

    public function show($id) {

        // Essa variável vai conter os dados do evento para o usuário que requisitar ele
        $event = Event::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;
        // variavel pra: se o usuario já saiu do evento

        if($user) {
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        // Pra saber que é o dono do evento 'eventOwner'.
        //                  usa o usuário de fato, não um parecido. O primeiro usuário encontrado, e to Array pra transformar os dados em Array
        $eventOwner = User::where('id', '=', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);

    }

    // Criar a action de dashboard pois está sob meu comando e não jetstream
    public function dashboard() {

        // pegar o usuário autenticado
        $user = auth()->user();

        // vamos utilizar a propriedade criada no Model pra verificar os eventos do usuário autenticado
        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.dashboard', ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]);

    }

    public function destroy($id) {

        try {
            Event::findOrFail($id)->delete();
            return redirect('/dashboard')->with('msg', 'Evento deletado com sucesso!');
        } catch(\Exception $e){
            return redirect('/dashboard')->with('error', 'Evento possui participantes, não é possível excluir');
        }



    }

    public function edit($id) {

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if($user->id != $event->user_id) {
            return redirect('/dashboard');
        }

        return view('events.edit', ['event' => $event]);

    }

    public function update(Request $request) {

        $data = $request->all();
        // Image Upload
        // Se o request possui uma imagem e essa imagem é válida, faz o processamento dos dados
        if($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;
            $extension = $requestImage->extension();

            // Cria uma string única baseado no tempo que ta dando upload e é colocado no md5 pra fazer uma hash
            // pego o nome do arquivo, acesso a propriedade imgae e o método getClientOriginalName() concatenado com o tempo de agora e com a extensão do arquivo
            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now") . "." . $extension);

            // Salvando a imagem no servidor na pasta events com o nome em hash
            $requestImage->move(public_path('img/events'), $imageName);

            // Atualiza a foto no banco
            $data['image'] = $imageName;

        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');

    }

    // receb o id do evento
    public function joinEvent($id) {

        $user = auth()->user();
        $users = User::where('id', $user->id)->first(); // necessário para pegar o id do usuário pelo model user

        // metodo criado 'eventAsParticipant' -> attach vai inserir o id do evento no id do usuário (na coluna na tabela pra ter os dados preenchidos)
        $users->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg','Sua presença está confirmada no evento ' . $event->title);

    }

    public function leaveEvent($id) {
        $user = auth()->user();

        $users = User::where('id', $user->id)->first(); // necessário para pegar o id do usuário pelo model user
        $users->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg','Você saiu com sucesso do evento: ' . $event->title);
    }
}
