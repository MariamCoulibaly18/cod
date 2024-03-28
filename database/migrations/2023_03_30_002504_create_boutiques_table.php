<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoutiquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boutiques', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("store_url");
            $table->string("consumer_key");
            $table->string("consumer_secret");            
            $table->unsignedBigInteger("user_id")->constrainted('users')->on_delete('cascade'); // 'cascade' means 'delete all boutiques of a user if this user is deleted
            $table->unsignedBigInteger("type_id")->constrainted('boutique_types')->on_delete('cascade'); // 'cascade' means 'delete all boutiques of a user if this user is deleted
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
        Schema::dropIfExists('boutiques');
    }
}
