<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLivreursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livreurs', function (Blueprint $table) {
            $table->id();
            $table->string('adresse')->nullable();;
            $table->integer('telephone');
            $table->string('matricule');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('societeTransport_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('societeTransport_id')->references('id')->on('societe_transports')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livreurs');
    }
}
