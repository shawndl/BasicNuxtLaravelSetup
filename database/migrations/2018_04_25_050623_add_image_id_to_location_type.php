<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageIdToLocationType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('location_types', function (Blueprint $table) {
            $table->unsignedInteger('image_id')->nullable();

            $table->foreign('image_id')
                ->references('id')
                ->on('images')
                ->cascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_types', function (Blueprint $table) {
            $table->dropForeign('location_types_image_id_foreign');
        });
    }
}
