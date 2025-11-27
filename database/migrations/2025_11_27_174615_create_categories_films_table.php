<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create("categories_films", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("film_id");

            $table
                ->foreign("category_id")
                ->references("id")
                ->on("categories")
                ->onDelete("cascade");
            $table
                ->foreign("film_id")
                ->references("id")
                ->on("films")
                ->onDelete("cascade");
        });
    }

    public function down()
    {
        Schema::dropIfExists("categories_films");
    }
};
