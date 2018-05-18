<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_type_id')->index();
            $table->unsignedInteger('user_id')->index();
            $table->text('description');
            $table->boolean('is_private')->default(false);
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();

            $table->foreign('location_type_id')
                ->references('id')
                ->on('location_types')
                ->cascade('delete');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('locations');
    }
}
