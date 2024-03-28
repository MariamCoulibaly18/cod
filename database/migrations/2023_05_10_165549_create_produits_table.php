<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("description")->nullable();
            $table->string("sku")->nullable();
            $table->string('permalien')->nullable();
            $table->string("stock_status")->default("instock");
            $table->string("pub_status")->default("publish");
            $table->integer("quantite")->default(1);
            $table->float("prix")->default(0);
            //boutique id
            $table->unsignedBigInteger('boutique_id');
            $table->timestamps();
            //contraintes
            $table->foreign('boutique_id')->references('id')->on('boutiques')->on_delete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produits');
    }
}
