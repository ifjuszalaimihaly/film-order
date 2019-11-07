<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTorrentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('torrents', function (Blueprint $table) {
            $table->charset = 'utf8';
            $table->collation = 'utf8_hungarian_ci';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('film_id');
            $table->string('file_name')->unique();
            $table->decimal("progress",3,2);
            $table->timestamps();

            $table->foreign('film_id')
                ->references('id')->on('films');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('torrents');
    }
}
