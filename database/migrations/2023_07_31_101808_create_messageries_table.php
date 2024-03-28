<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messageries', function (Blueprint $table) {
            $table->id();
            $table->string('status_messagerie');
            $table->unsignedBigInteger('template_id')->nullable();
            $table->unsignedBigInteger('api_messagerie_id')->nullable();
            $table->unsignedBigInteger('statut_livraison_id')->nullable();
            $table->timestamps();

            $table->foreign('template_id')->references('id')->on('templates')->on_delete('cascade');
            $table->foreign('api_messagerie_id')->references('id')->on('api_messageries')->on_delete('cascade');
            $table->foreign('statut_livraison_id')->references('id')->on('statut_livraisons')->on_delete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messageries');
    }
}
