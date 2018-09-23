<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('historial')->create('TBL_Procesos', function (Blueprint $table) {
            $table->increments('PK_PCS_Id');
            $table->string("PCS_Nombre");
            $table->string("PCS_Completitud_Documental");
            $table->integer('FK_PCS_Lineamiento')->unsigned();
            $table->timestamps();

            $table->foreign("FK_PCS_Lineamiento")->references("PK_LNM_Id")->on("TBL_Lineamientos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('historial')->dropIfExists('TBL_Procesos');

    }
}
