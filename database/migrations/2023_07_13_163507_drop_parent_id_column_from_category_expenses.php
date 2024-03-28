<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropParentIdColumnFromCategoryExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_expenses', function (Blueprint $table) {
        // Supprimez d'abord les contraintes de clés étrangères existantes
        $table->dropForeign(['parent_id']);

        // Ensuite, supprimez la colonne
        $table->dropColumn('parent_id');
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
