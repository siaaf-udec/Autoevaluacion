<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposInteresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Grupos_Interes', function (Blueprint $table) {
            $table->increments('PK_GIT_Id');
            $table->string("GIT_Nombre");
            $table->integer("FK_GIT_Estado")->unsigned();
            $table->timestamps();

            $table->foreign("FK_GIT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Grupos_Interes');
    }
}
