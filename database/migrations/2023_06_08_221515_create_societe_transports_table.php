<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocieteTransportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societe_transports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('adresse');
            $table->integer('telephone');
            $table->unsignedBigInteger('boutique_id');
            $table->timestamps();

            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societe_transports');
    }
}
