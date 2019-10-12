<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';
            $table->bigIncrements('id');
            $table->string('original_title')->unique();
            $table->string('translated_title')->unique()->nullable();
            $table->unsignedSmallInteger('release_year')->nullable();
            $table->string('imdb',10)->unique();
            $table->decimal('rating')->nullable();
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
        Schema::dropIfExists('films');
    }
}
