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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name')->index();

            $table->string('image_url');
            $table->string('image_name');
            $table->integer('image_size');

            $table->string('model_url');
            $table->string('model_name');
            $table->integer('model_size');

            $table->string('background_url')->nullable();
            $table->string('background_name')->nullable();
            $table->integer('background_size')->nullable();

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
        Schema::dropIfExists('products');
    }
};
