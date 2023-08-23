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
        Schema::create('document_cols', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_type_id')->references('id')->on('document_types')->onDelete('cascade'); //chave estrangeira
            $table->string('name'); //nome da coluna
            $table->integer('position'); //posicao da coluna
            $table->string('typecol'); //tipo da coluna
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
            Schema::dropIfExists('document_cols');
    }
};
