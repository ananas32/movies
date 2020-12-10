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
            $table->increments('id')->unsigned();
            $table->string('imdb_title_id', 255)->default(null);
            $table->text('title')->nullable();
            $table->text('year')->nullable();
//            $table->text('genre')->nullable();
            $table->text('duration')->nullable();
//            $table->text('country')->nullable();
//            $table->text('language')->nullable();
            $table->text('director')->nullable();
            $table->text('writer')->nullable();
            $table->text('actors')->nullable();
            $table->text('description')->nullable();
            $table->text('avg_vote')->nullable();
            $table->integer('votes')->nullable();
            $table->text('reviews_from_users')->nullable();
            $table->text('reviews_from_critics')->nullable();
            $table->boolean('is_usa')->nullable();
            $table->boolean('is_europe')->nullable();
            $table->boolean('is_top')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('country_movie', function (Blueprint $table) {
            $table->integer('country_id')->unsigned();
            $table->integer('movie_id')->unsigned();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onDelete('cascade');

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('cascade');
        });

        Schema::create('genre_movie', function (Blueprint $table) {
            $table->integer('genre_id')->unsigned();
            $table->integer('movie_id')->unsigned();

            $table->foreign('genre_id')
                ->references('id')
                ->on('genres')
                ->onDelete('cascade');

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('cascade');
        });

        Schema::create('language_movie', function (Blueprint $table) {
            $table->integer('language_id')->unsigned();
            $table->integer('movie_id')->unsigned();

            $table->foreign('language_id')
                ->references('id')
                ->on('languages')
                ->onDelete('cascade');

            $table->foreign('movie_id')
                ->references('id')
                ->on('movies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('country_movie');
        Schema::dropIfExists('genre_movie');
        Schema::dropIfExists('language_movie');
        Schema::dropIfExists('movies');
    }
}
