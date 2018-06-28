<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePonderacionRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Ponderacion_Respuestas', function (Blueprint $table) {
            $table->increments('PK_PRT_Id');
            $table->string("PRT_Titulo");
            $table->float("PRT_Ponderacion");
            $table->integer("FK_PRT_TipoRespuestas")->unsigned();
            $table->timestamps();

            $table->foreign("FK_PRT_TipoRespuestas")->references("PK_TRP_Id")->on("TBL_Tipo_Respuestas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Ponderacion_Respuestas');
    }
}
