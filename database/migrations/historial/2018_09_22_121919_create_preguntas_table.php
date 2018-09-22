<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Preguntas', function (Blueprint $table) {
            $table->increments('PK_PGT_Id')->index();
            $table->string("PGT_Texto", 10000);
            $table->integer("FK_PGT_Caracteristica")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PGT_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Preguntas');
    }
}
