<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imdb_name_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('height', 255)->nullable();
            $table->text('bio')->nullable();
            $table->string('date_of_birth', 255)->nullable();
            $table->string('place_of_birth', 255)->nullable();
            $table->string('children', 255)->nullable();
            $table->boolean('is_usa')->nullable();
            $table->boolean('is_europe')->nullable();
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
        Schema::dropIfExists('casts');
    }
}
