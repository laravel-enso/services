<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('measurement_unit_id')->unsigned();
            $table->foreign('measurement_unit_id')->references('id')
                ->on('measurement_units');

            $table->string('name');
            $table->string('code')->unique();

            $table->decimal('list_price', 13, 4)->unsigned();
            $table->tinyInteger('vat_percent')->unsigned();

            $table->string('description')->nullable();

            $table->boolean('is_active');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
};
