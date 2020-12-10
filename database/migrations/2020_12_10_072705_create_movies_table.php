<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');

            $table->string('imdb_title_id', 255)->default(null);

            $table->string('title', 255)->default(null);
            $table->string('year', 255)->default(null);
            $table->string('genre', 255)->default(null);
            $table->string('duration', 255)->default(null);
            $table->string('country', 255)->default(null);
            $table->string('language', 255)->default(null);
            $table->string('director', 255)->default(null);
            $table->string('writer', 255)->default(null);
            $table->string('actors', 255)->default(null);
            $table->string('description', 255)->default(null);
            $table->string('avg_vote', 255)->default(null);
            $table->string('votes', 255)->default(null);
            $table->string('reviews_from_users', 255)->default(null);
            $table->string('reviews_from_critics', 255)->default(null);
            $table->string('is_usa', 255)->default(null);
            $table->string('is_europe', 255)->default(null);
            $table->string('is_top', 255)->default(null);
            $table->softDeletes();
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
        Schema::dropIfExists('movies');
    }
}
