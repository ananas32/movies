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
            $table->text('title')->nullable();
            $table->text('year')->nullable();
            $table->text('genre')->nullable();
            $table->text('duration')->nullable();
            $table->text('country')->nullable();
            $table->text('language')->nullable();
            $table->text('director')->nullable();
            $table->text('writer')->nullable();
            $table->text('actors')->nullable();
            $table->text('description')->nullable();
            $table->double('avg_vote',2, 2)->nullable();
            $table->integer('votes')->nullable();
            $table->text('reviews_from_users')->nullable();
            $table->text('reviews_from_critics')->nullable();
            $table->string('is_usa', 255)->nullable();
            $table->string('is_europe', 255)->nullable();
            $table->string('is_top', 255)->nullable();
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
