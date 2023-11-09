<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // constrained() => atributo do Laravel pra entender que toda essa lógica pega uma chave estrangeira(foreingId) e atrela ela a um usuário de uma outra tabela
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // deletar os registros que estão atrelado a esse usuário pra não ficar "um filho sem pai"
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }
}
