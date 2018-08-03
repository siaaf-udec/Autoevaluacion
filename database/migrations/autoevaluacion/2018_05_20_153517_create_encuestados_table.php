<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Encuestados', function (Blueprint $table) {
            $table->increments('PK_ECD_Id');
            $table->date("ECD_FechaSolucion");
            $table->integer("FK_ECD_Encuesta")->unsigned();
            $table->integer("FK_ECD_GrupoInteres")->unsigned();
            $table->integer("FK_ECD_CargoAdministrativo")->unsigned()->nullable();

            $table->timestamps();

            $table->foreign("FK_ECD_Encuesta")->references("PK_ECT_Id")->on("TBL_Encuestas")->onDelete("cascade");
            $table->foreign("FK_ECD_GrupoInteres")->references("PK_GIT_Id")->on("TBL_Grupos_Interes")->onDelete("cascade");
            $table->foreign("FK_ECD_CargoAdministrativo")->references("PK_CAA_Id")->on("TBL_Cargos_Administrativos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Encuestados');
    }
}
