<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesMejoramiento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('autoevaluacion')->create('TBL_Actividades_Mejoramiento', function (Blueprint $table) {
            $table->increments('PK_ACM_Id');
            $table->string("ACM_Nombre");
            $table->mediumText("ACM_Descripcion")->nullable();
            $table-date("ACM_Fecha_Inicio");
            $table-date("ACM_Fecha_Fin");
            $table->integer("FK_ACM_Caracteristica")->unsigned();
            $table->integer("FK_ACM_Plan_Mejoramiento")->unsigned();
            $table->timestamps();

            $table->foreign("FK_ACM_Caracteristica")->references("PK_CRT_Id")->on("TBL_Caracteristicas")->onDelete("cascade");
	    $table->foreign("FK_ACM_Plan_Mejoramiento")->references("PK_PDM_Id")->on("TBL_Plan_De_Mejoramiento")->onDelete("cascade");
});    

}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Actividades_Mejoramiento');
    }
}
