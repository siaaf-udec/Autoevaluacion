<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('autoevaluacion')->create('TBL_Estados', function (Blueprint $table) {
            $table->increments('PK_ESD_Id')->unsigned()->unique();
            $table->string("ESD_Nombre", 60);
            $table->boolean("ESD_Valor");
        });
        Schema::connection('autoevaluacion')->table('users', function (Blueprint $table) {
            $table->unsignedInteger('id_estado')->nullable();
            $table->foreign('id_estado')->references('PK_ESD_Id')->on("TBL_Estados")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('autoevaluacion')->table('users', function (Blueprint $table) {
            $table->dropForeign('users_id_estado_foreign');
            $table->dropColumn('id_estado');
        });
        Schema::connection('autoevaluacion')->dropIfExists('TBL_Estados');
        

    }
}
