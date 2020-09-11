<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('cod_cmp')->default("0")->nullable();
            $table->integer('tipo_identificacion')->comment('Especifica la Nacionalidad > 1 es Peruana y > 0 Extrangero');
            $table->integer('dni');
            $table->string('nombres');
            $table->string('apellidos');
            $table->integer('edad');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('telefono')->nullable();
            $table->bigInteger('celular')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
