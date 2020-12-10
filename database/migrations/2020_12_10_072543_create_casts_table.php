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
            $table->string('imdb_name_id')->default(null);
            $table->string('name', 255)->default(null);
            $table->string('height', 255)->default(null);
            $table->string('bio', 255)->default(null);
            $table->string('date_of_birth', 255)->default(null);
            $table->string('place_of_birth', 255)->default(null);
            $table->string('children', 255)->default(null);
            $table->string('is_usa', 255)->default(null);
            $table->string('is_europe', 255)->default(null);
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
