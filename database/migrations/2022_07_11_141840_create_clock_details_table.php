<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClockDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clock_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->time('clock_in', $precision = 0)->nullable();
            $table->time('clock_out', $precision = 0)->nullable();
            $table->float('clock_in_lat')->nullable();
            $table->float('clock_in_lng')->nullable();
            $table->text('clock_in_location')->nullable();
            $table->float('clock_out_lat')->nullable();
            $table->float('clock_out_lng')->nullable();
            $table->text('clock_out_location')->nullable();


            $table->integer('category_id')->unsigned();
            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('clock_details');
    }
}
