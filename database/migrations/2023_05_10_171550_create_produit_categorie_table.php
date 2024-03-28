<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduitCategorieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_categorie', function (Blueprint $table) {
            $table->unsignedBigInteger("produit_id");
            $table->unsignedBigInteger("categorie_id");
            
            $table->foreign("produit_id")->references("id")->on("produits")->onDelete("cascade");
            $table->foreign("categorie_id")->references("id")->on("categories")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produit_categorie');
    }
}
