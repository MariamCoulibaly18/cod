<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidedParentCategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provided_parent_categorys', function (Blueprint $table) {
            $table->unsignedBigInteger('provided_id');
            $table->unsignedBigInteger('parent_id');

            $table->foreign('parent_id')->references('id')->on('parent_categorys')->on_delete('cascade');
            $table->foreign('provided_id')->references('id')->on('provideds')->onDelete('cascade');
            
            $table->primary(['provided_id', 'parent_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provided_parent_categorys');
    }
}
