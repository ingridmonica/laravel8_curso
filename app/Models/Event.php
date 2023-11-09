<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Vamos dizer por meio de um $cast(sintaxe especial do Laravel) que o item é um array
    protected $casts = [
        'items' => 'array'
    ];

    // dizer pra o laravel que tem um campo de data novo
    protected $dates = ['date'];

    // tudo que está sendo enviado pelo POST pode ser atualizado, não tem nenuma restrição => []
    protected $guarded = [];

    // Um usuário que é dono do evento  ( atrelando usuário a eventos, One to Many)
    public function user() {
        // quer dizer que pertence a alguém, a um usuário -> user
       return $this->belongsTo('App\Models\User');
    }

    // dizer que os eventos tem muitos usuários (relation  Many to Many)
    public function users() {
        //            pertence a muitos
        return $this->belongsToMany('App\Models\User');
    }

}



