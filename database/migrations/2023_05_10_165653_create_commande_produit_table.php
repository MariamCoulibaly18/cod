<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeProduitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_produit', function (Blueprint $table) {
            $table->unsignedBigInteger("commande_id");
            $table->unsignedBigInteger("produit_id");
            $table->integer("quantite")->default(1);
            $table->float('prix')->default(0.0);
            $table->timestamps();

            $table->foreign("commande_id")->references("id")->on("commandes")->onDelete("cascade");
            $table->foreign("produit_id")->references("id")->on("produits")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_produit');
    }
}
