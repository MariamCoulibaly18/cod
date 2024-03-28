<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table ->string('prenom');
            $table ->string('nom');
            $table ->string('email');
            $table ->string('telephone');
            $table ->string('adresse');
            $table ->string('pays');
            $table ->string('ville')->nullable();
            $table ->string('type_payement')->nullable();
            
            $table->foreignId("boutique_id")->constrainted('boutiques')->on_delete('cascade'); // 'cascade' means 'delete all clients of a boutique if this boutique is deleted
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
        Schema::dropIfExists('clients');
    }
}
