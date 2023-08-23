<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_col_id');
            $table->foreign('document_col_id')->references('id')->on('document_cols')->onDelete('cascade'); //chave estrangeira
            $table->text('value'); //valor da coluna
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
        Schema::dropIfExists('document_values');
    }
};
