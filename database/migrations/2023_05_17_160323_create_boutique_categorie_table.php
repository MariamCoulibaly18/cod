<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoutiqueCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boutique_categorie', function (Blueprint $table) {
            $table->unsignedBigInteger('boutique_id');
            $table->unsignedBigInteger('categorie_id');
            //contraintes
            $table->foreign('boutique_id')->references('id')->on('boutiques')->on_delete('cascade');
            $table->foreign('categorie_id')->references('id')->on('categories')->on_delete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boutique_categorie');
    }
}
