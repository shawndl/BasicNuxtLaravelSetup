<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $defaultIcon = config('app.url') . 'public/storage/icon/default-map-icon.png';
        Schema::create('location_types', function (Blueprint $table) use ($defaultIcon) {
            $table->increments('id');
            $table->string('name')->index();
            $table->text('description');
            $table->date('season_start');
            $table->date('season_finish');
            $table->string('icon')->default($defaultIcon);
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
        Schema::dropIfExists('location_types');
    }
}
