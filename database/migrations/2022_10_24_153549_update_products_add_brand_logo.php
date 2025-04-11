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
            $table->string('brand_image_url')->nullable()->after('grid_image_size');
            $table->string('brand_image_name')->nullable()->after('brand_image_url');
            $table->integer('brand_image_size')->nullable()->after('brand_image_name');
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
            $table->dropColumn('brand_image_url');
            $table->dropColumn('brand_image_name');
            $table->dropColumn('brand_image_size');
        });
    }
};
