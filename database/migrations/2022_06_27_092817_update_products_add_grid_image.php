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
        Schema::table('products', function (Blueprint $table) {
            $table->string('grid_image_url')->default('default')->after('background_size');
            $table->string('grid_image_name')->default('default')->after('grid_image_url');
            $table->integer('grid_image_size')->default(0)->after('grid_image_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('grid_image_size');
            $table->dropColumn('grid_image_name');
            $table->dropColumn('grid_image_url');
        });
    }
};
