<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAspectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Aspectos', function (Blueprint $table) {
            $table->increments('PK_ASP_Id');
            $table->mediumText("ASP_Nombre");
            $table->mediumText("ASP_Descripcion")->nullable();
            $table->string("ASP_Identificador");
            $table->integer("FK_ASP_Caracteristica")->unsigned();
            $table->timestamps();

            $table->foreign("FK_ASP_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Aspectos');
    }
}
