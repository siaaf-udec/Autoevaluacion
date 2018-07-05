<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Encuestas', function (Blueprint $table) {
            $table->increments('PK_ECT_Id');
            $table->date("ECT_FechaPublicacion");
            $table->date("ECT_FechaFinalizacion");
            $table->integer("FK_ECT_Estado")->unsigned();
            $table->integer("FK_ECT_Proceso")->unsigned();
            $table->timestamps();

            $table->foreign("FK_ECT_Proceso")->references("PK_PCS_Id")->on("TBL_Procesos")->onDelete("cascade");
            $table->foreign("FK_ECT_Estado")->references("PK_ESD_Id")->on("TBL_Estados")->onDelete("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Encuestas');
    }
}
