<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeDepenseIdColumnToCategoryExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_expenses', function (Blueprint $table) {
            $table->Integer('type_depense_id')->nullable();
            $table->foreign('type_depense_id')->references('id')->on('type_depenses')->on_delete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_expenses', function (Blueprint $table) {
            //
        });
    }
}
