<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('service_supplier', function (Blueprint $table) {
            $table->id();

            $table->integer('supplier_id')->unsigned();
            $table->foreign('supplier_id')->references('id')->on('companies');

            $table->integer('service_id')->unsigned();
            $table->foreign('service_id')->references('id')->on('services');

            $table->decimal('acquisition_price')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('service_supplier');
    }
};
