<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatutLivraisonIdColumnToLivreurCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('livreur_commandes', function (Blueprint $table) {
            $table->unsignedBigInteger('statut_livraison_id')->nullable();
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
        Schema::table('livreur_commandes', function (Blueprint $table) {
            //
        });
    }
}
