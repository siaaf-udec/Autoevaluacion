<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosAdministrativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TBL_Cargos_Administrativos', function (Blueprint $table) {
            $table->increments('PK_CAA_Id');
            $table->string("CAA_Cargo", 150);
            $table->integer("FK_CAA_AlcanceCargo")->unsigned();
            $table->timestamps();
            $table->foreign("FK_CAA_AlcanceCargo")->references("PK_AAD_Id")->on("TBL_Alcances_Administrativos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TBL_Cargos_Administrativos');
    }
}
