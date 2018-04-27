<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncyclopediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encyclopedias', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name')->index();
            $table->string('path');
            $table->unsignedInteger('encyclopedia_id');
            $table->string('encyclopedia_type');

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
        Schema::dropIfExists('encyclopedias');
    }
}
