<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->date('date');
            $table->string('note')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('boutique_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provided_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('boutique_id')->references('id')->on('boutiques')->onDelete('cascade');
            $table->foreign('provided_id')->references('id')->on('provided')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_expenses');
    }
}
