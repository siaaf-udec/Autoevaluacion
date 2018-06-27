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
        Schema::create('TBL_Preguntas', function (Blueprint $table) {
            $table->increments('PK_PGT_Id');
            $table->string("PGT_Texto", 150);
            $table->integer("FK_PGT_Estado")->unsigned();
            $table->integer("FK_PGT_TipoRespuesta")->unsigned();
            $table->integer("FK_PGT_Aspecto")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PGT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
            $table->foreign("FK_PGT_TipoRespuesta")->references("PK_TRP_Id")->on("TBL_Tipo_Respuestas")->onDelete("cascade");
            $table->foreign("FK_PGT_Aspecto")->references("PK_EDC_Id")->on("TBL_Indicadores")->onDelete("cascade");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Preguntas');
    }
}
