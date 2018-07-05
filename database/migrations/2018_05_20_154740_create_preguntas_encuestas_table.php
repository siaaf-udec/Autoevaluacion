<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Preguntas_Encuestas', function (Blueprint $table) {
            $table->increments('PK_PEN_Id');
            $table->integer("FK_PEN_Pregunta")->unsigned();
            $table->integer("FK_PEN_Encuesta")->unsigned();
            $table->integer("FK_PEN_GrupoInteres")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PEN_Pregunta")->references("PK_PGT_Id")->on("TBL_Preguntas")->onDelete("cascade");
            $table->foreign("FK_PEN_Encuesta")->references("PK_ECT_Id")->on("TBL_Encuestas")->onDelete("cascade");
            $table->foreign("FK_PEN_GrupoInteres")->references("PK_GIT_Id")->on("TBL_Grupos_Interes")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Preguntas_Encuestas');
    }
}
