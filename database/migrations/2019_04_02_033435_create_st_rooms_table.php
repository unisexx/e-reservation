<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->nullable();
            $table->string('people')->nullable();
            $table->string('equipment')->nullable();
            $table->string('res_name')->nullable();
            $table->string('res_tel')->nullable();
            $table->integer('res_department_id')->nullable();
            $table->string('fee')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->nullable();
            $table->string('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('st_rooms');
    }
}
