<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('st_vehicle_type_id')->nullable();
            $table->string('brand')->nullable();
            $table->string('seat')->nullable();
            $table->string('color')->nullable();
            $table->string('reg_number')->nullable();
            $table->integer('res_department_id')->nullable();
            $table->integer('st_driver_id')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('st_vehicles');
    }
}
