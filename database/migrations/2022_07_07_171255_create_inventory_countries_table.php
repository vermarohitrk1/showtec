<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_countries', function (Blueprint $table) {
            $table->bigInteger('inventory_id')->unsigned(); 
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('quantity')->default(0);  

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('inventory_id')->references('id')->on('inventories')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
            $table->primary(['inventory_id','country_id']);
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
        Schema::dropIfExists('inventory_countries');
    }
}
