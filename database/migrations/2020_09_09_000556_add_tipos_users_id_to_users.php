<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTiposUsersIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('tipo_user_id')->comment('Especifica el tipo de usuario de la tabla tipos_user');;
            $table->foreign('tipo_user_id')->references('id')->on('tipos_user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['tipo_user_id']);
            $table->dropColumn('tipo_user_id');
        });
    }
}
